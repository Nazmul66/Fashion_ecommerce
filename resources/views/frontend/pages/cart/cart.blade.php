@php
   if( $userCartData ){
        $total_cart_sum = 0; 
        foreach( $userCartData as $cartData ){
            $total_cart_sum += $cartData->price * $cartData->qty;
        }
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

                        <tbody id='cart_show'>    
                            
                            @if( !$userCartData )
                                <div class="alert alert-danger text-center" role="alert">
                                    There is no data here!
                                </div>
                            @endif
                            {{-- @if ( !empty( $userCartData ) && $userCartData->count() > 0 )
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
                                    <td class="remove-col"><button class="btn-remove" data-id="{{ $cartData->cart_id }}"><i class="icon-close"></i></button></td>
                                </tr>
                                @endforeach
                            @else
                              <td colspan="5">
                                <div class="alert alert-danger text-center" role="alert">
                                    There is no data here!
                                  </div>
                              </td>
                            @endif --}}
                        </tbody>
                    </table><!-- End .table table-wishlist -->

                    <div class="cart-bottom">
                        <div class="cart-discount">
                            <form action="#">
                                <div class="input-group">
                                    <input type="text" class="form-control" required placeholder="coupon code">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End .col-lg-9 -->

                <aside class="col-lg-3">
                    <div class="summary summary-cart">
                        <h3 class="summary-title">Cart Total</h3>

                        <table class="table table-summary">
                            <tbody>
                                <tr class="summary-subtotal">
                                    <td>Subtotal:</td>
                                    <td>
                                        @if( !empty($userCartData ) )
                                            ${{number_format($total_cart_sum, 2) }}
                                        @endif
                                    </td>
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

                console.log(qty, productId);

                $.ajax({
                    url: '{{ route("cart.updateQuantity") }}', // Define this route in your web.php
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: qty
                    },
                    success: function(res) {
                        if (res.status) {
                            console.log(res);

                            row.find('.total-col').text('$' + (res.newItemTotal).toFixed(2));
                            
                            // Update the cart subtotal
                            $('.summary-subtotal td:last-child').text('$' + (res.cartTotal).toFixed(2));
                            $('.cart-total-price').text('$' + (res.cartTotal).toFixed(2));

                            header();

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


         // header cart products show
           function header () {
            $.ajax({
                method: "GET",
                url: "{{ route('getCart.data') }}",
                dataType: "json",
                success: function(res){
                    $('#cart-count').html(res.success.length);

                    var carts = '';

                    if (res.success.length > 0) { 
                        $.each(res.success, function(index, item){
                            carts += `
                                <div class="product">
                                    <div class="product-cart-details">
                                        <h4 class="product-title">
                                            <a href="{{ url('/product-details/`+item.slug+`') }}">`+ item.title +`</a>
                                        </h4>

                                        <span class="cart-product-info">
                                            <span class="cart-product-qty">`+ item.qty +`</span>
                                            x $ `+ item.price.toFixed(2) +`
                                        </span>
                                    </div>

                                    <figure class="product-image-container">
                                        <a href="{{ url('/product-details/`+ item.slug +`') }} " class="product-image">
                                            <img src="{{ asset('`+ item.thumbnail +`') }}" alt="product">
                                        </a>
                                    </figure>
                                    <a href="{{ url('/delete/cart/`+ item.cart_id +`') }}" class="btn-remove" title="Remove Product"><i class="icon-close"></i></button>
                                </div>`;
                            });
                        }  
                        else {
                            carts = `
                            <div class="alert alert-danger text-center" role="alert">
                                There is no data here!
                            </div>`;
                        }

                    $('#product_show').html(carts);

                },
                error: function (err){
                    console.log(err);
                }
            })
        }


        // cart section product show
        function cart_section_data(){
            $.ajax({
            method: "GET",
            url: "{{ route('getCart.data') }}",
            dataType: "json",
            success: function(res){
                var tbody = '';

                if (res.success.length > 0) {
                    // Iterate over each cart item in the response
                    $.each(res.success, function(index, item) {
                        // Construct HTML for each cart item
                        tbody += `
                            <tr>
                                <td class="product-col">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href="{{ url('/product-details/') }}/${item.slug}">
                                                <img src="${item.thumbnail}" alt="Product image">
                                            </a>
                                        </figure>
                                        <h3 class="product-title">
                                            <a href="{{ url('/product-details/') }}/${item.slug}">${item.title}</a>
                                        </h3>
                                    </div>
                                </td>
                                <td class="price-col">$`+ item.price.toFixed(2) +`</td>
                                <td class="quantity-col">
                                    <div class="cart-product-quantity">
                                        <input type="hidden" value="${item.product_id}" class="product_id">
                                        <input type="number" class="form-control prdt_qty" value="${item.qty}" min="1" max="10" step="1" data-decimals="0" required>
                                    </div>
                                </td>
                                <td class="total-col">$`+ (item.price * item.qty).toFixed(2) +`</td>
                                <td class="remove-col"><a href="{{ url('/delete/cart/`+ item.cart_id +`') }}" class="btn-remove" data-id="${item.cart_id}"><i class="icon-close"></i></a></td>
                            </tr>`;
                    });

                    } else {
                        tbody = `
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger text-center" role="alert">
                                        There is no data here!
                                    </div>
                                </td>
                            </tr>`;
                    }

                    $('#cart_show').html(tbody);
                },
                error: function (err){
                    console.log(err);
                }
            });
            }

         // initialily cart data show
         cart_section_data();
    })

  </script>
@endpush