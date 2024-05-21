@php
    $total_cart_sum = 0; 
    foreach( $userCartData as $cartData ){
        $total_cart_sum += $cartData->price * $cartData->qty;
    }
@endphp


@extends('frontend.layout.template')

@push('meta-title')
    Ecommerce - cart pages
@endpush

@section('body-content')

<div class="page-header text-center" style="background-image: url({{ asset('public/frontend/assets/images/page-header-bg.jpg') }})">
    <div class="container">
        <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
    </div>
</div>

<!-- Breadcrumb section start -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
        </ol>
    </div><!-- End .container -->
</nav>
<!-- Breadcrumb section end -->

<div class="page-content">
    <div class="cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <table class="table table-cart table-mobile">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach ($userCartData as $cartData)
                            <tr>
                                <td class="product-col">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href="{{ route('product.details', $cartData->slug) }}">
                                                <img src="{{ asset($cartData->thumbnail) }}" alt="Product image">
                                            </a>
                                        </figure>
                            
                                        <h3 class="product-title">
                                            <a href="{{ route('product.details', $cartData->slug) }}">{{ $cartData->title }}</a>
                                        </h3>
                                    </div>
                                </td>
                                <td class="price-col">${{ number_format($cartData->price) }}</td>
                                <td class="quantity-col">
                                    <div class="cart-product-quantity">
                                        <input type="hidden" value="{{ $cartData->product_id }}" class="product_id">
                                        <input type="number" class="form-control prdt_qty" value="{{ $cartData->qty }}" min="1" max="10" step="1" data-decimals="0" required>
                                    </div>
                                </td>
                                <td class="total-col">${{ number_format($cartData->price * $cartData->qty, 2) }}</td>
                                <td class="remove-col"><button class="btn-remove"><i class="icon-close"></i></button></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table><!-- End .table table-wishlist -->

                    <div class="cart-bottom">
                        <div class="cart-discount">
                            <form action="#">
                                <div class="input-group">
                                    <input type="text" class="form-control" required placeholder="coupon code">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- End .input-group -->
                            </form>
                        </div><!-- End .cart-discount -->

                        <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
                    </div><!-- End .cart-bottom -->
                </div><!-- End .col-lg-9 -->
                <aside class="col-lg-3">
                    <div class="summary summary-cart">
                        <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                        <table class="table table-summary">
                            <tbody>
                                <tr class="summary-subtotal">
                                    <td>Subtotal:</td>
                                    <td>${{ number_format($total_cart_sum, 2) }}</td>
                                </tr><!-- End .summary-subtotal -->
                                <tr class="summary-shipping">
                                    <td>Shipping:</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="free-shipping" name="shipping" class="custom-control-input">
                                            <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>$0.00</td>
                                </tr><!-- End .summary-shipping-row -->

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="standart-shipping" name="shipping" class="custom-control-input">
                                            <label class="custom-control-label" for="standart-shipping">Standart:</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>$10.00</td>
                                </tr><!-- End .summary-shipping-row -->

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
                                            <label class="custom-control-label" for="express-shipping">Express:</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>$20.00</td>
                                </tr><!-- End .summary-shipping-row -->

                                <tr class="summary-shipping-estimate">
                                    <td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
                                    <td>&nbsp;</td>
                                </tr><!-- End .summary-shipping-estimate -->

                                <tr class="summary-total">
                                    <td>Total:</td>
                                    <td>$160.00</td>
                                </tr><!-- End .summary-total -->
                            </tbody>
                        </table><!-- End .table table-summary -->

                        <a href="checkout.html" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                    </div><!-- End .summary -->

                    <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .cart -->
</div><!-- End .page-content -->

@endsection


@push('scripts')
  <script>
       $(document).ready(function(){
            $(document).on('change', ".prdt_qty", function() {
                var qty = $(this).val();
                var row = $(this).closest('tr');
                var productId = row.find('.product_id').val();

                $.ajax({
                    url: '{{ route("cart.updateQuantity") }}', // Define this route in your web.php
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: qty
                    },
                    success: function(res) {
                        if (res.status) {
                            // Update the item's total price
                            // console.log(itemTotal);

                            row.find('.total-col').text('$' + (res.newItemTotal).toFixed(2));

                            // Update the cart subtotal
                            $('.summary-subtotal td:last-child').text('$' + (res.cartTotal).toFixed(2));

                            // Optionally, update other cart totals if needed
                        } else {
                            console.log(res.message);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
       })
  </script>
@endpush