@php
   if( $carts ){
        $total_cart_sum = 0; 
        foreach( $carts as $cartData ){
            $total_cart_sum += $cartData->price * $cartData->qty;
        }
   }
@endphp


@extends('frontend.layout.template')

@push('meta-title')
    Ecommerce - checkout pages
@endpush

@section('body-content')

<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
    <div class="container">
        <h1 class="page-title">Checkout<span>Shop</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="checkout">
        <div class="container">
            <div class="checkout-discount">
                <form action="#">
                    <input type="text" class="form-control" required id="checkout-discount-input">
                    <label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
                </form>
            </div><!-- End .checkout-discount -->
            <form action="#">
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>First Name *</label>
                                    <input type="text" class="form-control" required>
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label>Last Name *</label>
                                    <input type="text" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <label>Company Name (Optional)</label>
                            <input type="text" class="form-control">

                            <label>Country *</label>
                            <input type="text" class="form-control" required>

                            <label>Street address *</label>
                            <input type="text" class="form-control" placeholder="House number and Street name" required>
                            <input type="text" class="form-control" placeholder="Appartments, suite, unit etc ..." required>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Town / City *</label>
                                    <input type="text" class="form-control" required>
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label>State / County *</label>
                                    <input type="text" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Postcode / ZIP *</label>
                                    <input type="text" class="form-control" required>
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label>Phone *</label>
                                    <input type="tel" class="form-control" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Email address *</label>
                                    <input type="email" class="form-control" required>
                                </div>

                                <div class="col-sm-6">
                                    <label>Shipping Charge *</label>
                                    <select class="form-control" id="shipping" aria-label="Default select example">
                                        <option value="0" selected>Free Shipping Cost</option>

                                        @foreach ($shippingCharges as $shipping)
                                            <option value="{{ $shipping->price }}">{{ $shipping->name }}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkout-create-acc">
                                <label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
                            </div><!-- End .custom-checkbox -->

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkout-diff-address">
                                <label class="custom-control-label" for="checkout-diff-address">Ship to a different address?</label>
                            </div><!-- End .custom-checkbox -->

                            <label>Order notes (optional)</label>
                            <textarea class="form-control" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary">
                            <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ( $carts as $cart )
                                        <tr>
                                            <td><a href="#">{{ $cart->title }} ({{ $cart->qty }}  X {{ $cart->price }} {{ $cart->unit }})</a></td>
                                            <td>${{ number_format($cart->qty * $cart->price, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>${{ number_format($total_cart_sum, 2) }}</td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr>
                                        <td colspan="2">
                                            <div class="cart-discount">
                                                <div class="input-group">
                                                    <input type="text" id="apply_discount_coupon" class="form-control" placeholder="coupon code">
                                                    <div class="input-group-append">
                                                        <button id="discount_btn" class="btn btn-outline-primary-2" type="button"><i class="icon-long-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Discount:</td>
                                        <td>- $<span id="discount_amount">0.00</span></td>
                                        <input type="text" id="discount_price" value="0" name="discount_price">
                                    </tr>
                                    <tr>
                                        <td>Shipping:</td>
                                        <td>+ $<span id="shipping_amount">0.00</span></td>
                                        <input type="text" id="shipping_price" value="0" name="shipping_price">
                                    </tr>
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>$<span data-val="{{ $total_cart_sum }}" id="total_amount">{{ number_format($total_cart_sum, 2) }}</span></td>
                                        <input type="text" id="total_cart_price" value="{{ $total_cart_sum }}" name="total_cart_price">
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <div class="accordion-summary" id="accordion-payment">
                                <div class="card">
                                    <div class="card-header" id="heading-3">
                                        <h2 class="card-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                                Cash on delivery
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-payment">
                                        <div class="card-body">Quisque volutpat mattis eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. 
                                        </div>
                                    </div>
                                </div><!-- End .card -->

                                <div class="card">
                                    <div class="card-header" id="heading-4">
                                        <h2 class="card-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                                PayPal <small class="float-right paypal-link">What is PayPal?</small>
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-payment">
                                        <div class="card-body">
                                            Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum.
                                        </div>
                                    </div>
                                </div><!-- End .card -->

                                <div class="card">
                                    <div class="card-header" id="heading-5">
                                        <h2 class="card-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                                Credit Card (Stripe)
                                                <img src="{{ asset('public/frontend/assets/images/payments-summary.png') }}" alt="payments cards">
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-payment">
                                        <div class="card-body"> Donec nec justo eget felis facilisis fermentum.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Lorem ipsum dolor sit ame.
                                        </div>
                                    </div>
                                </div><!-- End .card -->
                            </div><!-- End .accordion -->

                            <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                <span class="btn-text">Place Order</span>
                                <span class="btn-hover-text">Proceed to Checkout</span>
                            </button>
                        </div>
                    </aside>
                </div>
            </form>
        </div>
    </div>
</div><!-- End .page-content -->

@endsection


@push('scripts')
    <script>
        $(document).ready(function(){

            $('#discount_btn').click(function(){
               var discount_code = $('#apply_discount_coupon').val();
                // console.log(discount_code);

                $.ajax({
                    method: "POST", 
                    url: "{{ route('discount.code') }}", 
                    data: { discount_code : discount_code },
                    success: function( data ){
                        // console.log(data);
                        var shipping = $('#shipping_price').val();
                        var final_amount = parseInt(shipping) + parseInt(data.total) ;

                        $('#discount_amount').html(parseInt(data.discount_amount).toFixed(2))
                        $('#total_amount').html(final_amount.toFixed(2));
                        $('#total_cart_price').val(parseInt(data.total));
                        $('#discount_price').val(parseInt(data.discount_amount));
                    },
                    error: function( err ){
                        console.log(err);
                    },
                })
            })


            // Shipping Charges
            $('#shipping').change(function(){
                var price = parseInt($(this).val());
                var total_price = parseInt($('#total_cart_price').val());
                console.log(price + total_price);

                $('#total_amount').html((total_price + price).toFixed(2));
                $('#shipping_amount').html(price.toFixed(2));
                $('#shipping_price').val(price);
            })
        })
    </script>
@endpush