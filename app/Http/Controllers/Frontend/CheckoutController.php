<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ShippingCharge;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function checkout()
    {
        $carts = Cart::getCartUserData();
        $shippingCharges = ShippingCharge::getRecord();
        return view('frontend.pages.checkout.checkout', compact('carts', 'shippingCharges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout_place_order(Request $request)
    {
       // This is ( Cash On Delivery ) method
        if( $request->payment_method === "cash_on_delivery" ){
            $order = new Order();

            $order->user_id               = Auth::user()->id;
            $order->first_name            = $request->first_name;
            $order->last_name             = $request->last_name;
            $order->email                 = $request->email;
            $order->phone                 = $request->phone;
            $order->company_name          = $request->company_name;
            $order->address               = $request->address;
            $order->address_optional      = $request->address_optional;
            $order->country               = $request->country;
            $order->city                  = $request->city;
            $order->state                 = $request->state;
            $order->postcode              = $request->postcode;
            $order->order_note            = $request->order_note;
            $order->discount_price        = $request->discount_price;
            $order->shipping_price        = $request->shipping_price;
            $order->total_cart_price      = $request->total_cart_price;
            $order->payment_method        = $request->payment_method;
            $order->is_delete             = 1;
            $order->status                = 0;

            // dd($order);

            $order->save();

            // clear the all cart data
            foreach( Cart::where('order_id', null)->get() as $cart ){
                $cart->order_id =  $order->id;
                $cart->save();
            }

            return redirect()->back();
        }

        // This is ( SSL Commercez ) method
        else if( $request->payment_method === "ssl_commercez"){
            
                # Here you have to receive all the order data to initate the payment.
                # Let's say, your oder transaction informations are saving in a table called "orders"
                # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

                $post_data = array();
                $post_data['total_amount'] = '10'; # You cant not pay less than 10
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = uniqid(); // tran_id must be unique

                # CUSTOMER INFORMATION
                $post_data['cus_name'] = 'Customer Name';
                $post_data['cus_email'] = 'customer@mail.com';
                $post_data['cus_add1'] = 'Customer Address';
                $post_data['cus_add2'] = "";
                $post_data['cus_city'] = "";
                $post_data['cus_state'] = "";
                $post_data['cus_postcode'] = "";
                $post_data['cus_country'] = "Bangladesh";
                $post_data['cus_phone'] = '8801XXXXXXXXX';
                $post_data['cus_fax'] = "";

                # SHIPMENT INFORMATION
                $post_data['ship_name'] = "Store Test";
                $post_data['ship_add1'] = "Dhaka";
                $post_data['ship_add2'] = "Dhaka";
                $post_data['ship_city'] = "Dhaka";
                $post_data['ship_state'] = "Dhaka";
                $post_data['ship_postcode'] = "1000";
                $post_data['ship_phone'] = "";
                $post_data['ship_country'] = "Bangladesh";

                $post_data['shipping_method'] = "NO";
                $post_data['product_name'] = "Computer";
                $post_data['product_category'] = "Goods";
                $post_data['product_profile'] = "physical-goods";

                # OPTIONAL PARAMETERS
                $post_data['value_a'] = "ref001";
                $post_data['value_b'] = "ref002";
                $post_data['value_c'] = "ref003";
                $post_data['value_d'] = "ref004";

                #Before  going to initiate the payment order status need to insert or update as Pending.
                $update_product = DB::table('orders')
                    ->where('transaction_id', $post_data['tran_id'])
                    ->updateOrInsert([
                        'user_id' => Auth::user()->id,
                        'email' => $post_data['cus_email'],
                        'phone' => $post_data['cus_phone'],
                        'total_cart_price' => $post_data['total_amount'],
                        'status' => 'Pending',
                        'address' => $post_data['cus_add1'],
                        'transaction_id' => $post_data['tran_id'],
                        // 'currency' => $post_data['currency']
                    ]);

                // dd($update_product);

                $sslc = new SslCommerzNotification();
                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
                $payment_options = $sslc->makePayment($post_data, 'hosted');

                if (!is_array($payment_options)) {
                    print_r($payment_options);
                    $payment_options = array();
                }
        }

       // This is ( Stripe ) method
       else if ( $request->payment_method === "stripe" ){
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'T-shirt'
                        ],
                        'unit_amount' => 2000*100,
                    ],
                    'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
            ]);

            // dd($response);

            // to check if id have it will redirect the stripe payment gateway
            if( $response->id && $response->id != "" ){
                session()->put('first_name', $request->first_name);
                session()->put('last_name', $request->last_name);
                session()->put('email', $request->email);
                session()->put('phone', $request->phone);
                session()->put('company_name', $request->company_name);
                return redirect($response->url);
            }
            else{
                return redirect()->route('stripe.cancel');
            }

       }

        // This is ( Paypal ) method  
       else if ( $request->payment_method === "paypal" ){
        
       }
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {

        echo "Transaction is Successful";

        // $tran_id = $request->input('tran_id');
        // $amount = $request->input('amount');
        // $currency = $request->input('currency');

        // $sslc = new SslCommerzNotification();

        // #Check order status in order tabel against the transaction id or order id.
        // $order_details = DB::table('orders')
        //     ->where('transaction_id', $tran_id)
        //     ->select('transaction_id', 'status', 'currency', 'amount')->first();

        // if ($order_details->status == 'Pending') {
        //     $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        //     if ($validation) {
        //         /*
        //         That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
        //         in order table as Processing or Complete.
        //         Here you can also sent sms or email for successfull transaction to customer
        //         */
        //         $update_product = DB::table('orders')
        //             ->where('transaction_id', $tran_id)
        //             ->update(['status' => 'Processing']);

        //         echo "<br >Transaction is successfully Completed";
        //     }
        // } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
        //     /*
        //      That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
        //      */
        //     echo "Transaction is successfully Completed";
        // } else {
        //     #That means something wrong happened. You can redirect customer to your product page.
        //     echo "Invalid Transaction";
        // }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {
            
            $tran_id = $request->input('tran_id');
            
            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();
            
            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
    
    public function stripe_success(Request $request)
    {
        if( $request->session_id ){

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            // dd($response);
            echo session()->get('first_name');
            echo session()->get('last_name');
            echo session()->get('email');
            echo session()->get('phone');
            echo $request->session_id;

            unset($request->session_id);
            // session forget all session data
            session()->forget(['first_name', 'last_name', 'email', 'phone']);
        }
        
        else{
            return redirect()->route('stripe.cancel');
        }
    }

    public function stripe_cancel(Request $request)
    {
       return 'payment transaction is being cancel';
    }
}
