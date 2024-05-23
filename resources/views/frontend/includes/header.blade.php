@php
   if( Auth::check() ){
       $cart_count =  App\Models\Cart::where('order_id', NULL)->where('user_id', Auth::user()->id)->get();
   }

   $carts = App\Models\Cart::getCartUserData();

   if( $carts ){
        $total_cart_sum = 0; 
        foreach( $carts as $cartData ){
            $total_cart_sum += $cartData->price * $cartData->qty;
        }
   }
@endphp

<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <div class="header-dropdown">
                    <a href="#">Usd</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">Eur</a></li>
                            <li><a href="#">Usd</a></li>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->

                <div class="header-dropdown">
                    <a href="#">Eng</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">English</a></li>
                            <li><a href="#">French</a></li>
                            <li><a href="#">Spanish</a></li>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li><a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a></li>
                            <li><a href="wishlist.html"><i class="icon-heart-o"></i>My Wishlist <span>(3)</span></a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="index.html" class="logo">
                    <img src="{{ asset('public/frontend/assets/images/logo.png') }}" alt="Molla Logo" width="105" height="25">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="{{ route('home') }}" class="">Home</a>
                        </li>

                        <li>
                            <a href="category.html" class="sf-with-ul">Shop</a>

                            <div class="megamenu megamenu-md">
                                <div class="row no-gutters">
                                    <div class="col-md-12">
                                        <div class="menu-col">
                                            <div class="row">
                                                @foreach (App\Models\Category::getRecord() as $category)
                                                @if ( !empty(App\Models\SubCategory::getAllRecords($category->id)->count()) )
                                                 <div class="col-md-4 mb-3">
                                                    <a href="{{ route('get.category', $category->slug) }}" class="menu-title">{{ $category->name }}</a>
                                                    <ul>
                                                      @foreach (App\Models\SubCategory::getAllRecords($category->id) as $subCat)
                                                          <li>
                                                            <a href="{{ route('get.category', $category->slug . '/' .  $subCat->slug) }}">{{ $subCat->name }}</a>
                                                          </li>
                                                       @endforeach
                                                    </ul>
                                                 </div>
                                                 @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <a href="product.html" class="sf-with-ul">Product</a>

                            <div class="megamenu megamenu-sm">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <div class="menu-col">
                                            <div class="menu-title">Product Details</div><!-- End .menu-title -->
                                            <ul>
                                                <li><a href="product.html">Default</a></li>
                                                <li><a href="product-centered.html">Centered</a></li>
                                                <li><a href="product-extended.html"><span>Extended Info<span class="tip tip-new">New</span></span></a></li>
                                                <li><a href="product-gallery.html">Gallery</a></li>
                                                <li><a href="product-sticky.html">Sticky Info</a></li>
                                                <li><a href="product-sidebar.html">Boxed With Sidebar</a></li>
                                                <li><a href="product-fullwidth.html">Full Width</a></li>
                                                <li><a href="product-masonry.html">Masonry Sticky Info</a></li>
                                            </ul>
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-6 -->

                                    <div class="col-md-6">
                                        <div class="banner banner-overlay">
                                            <a href="category.html">
                                                <img src="{{ asset('public/frontend/assets/images/menu/banner-2.jpg') }}" alt="Banner">

                                                <div class="banner-content banner-content-bottom">
                                                    <div class="banner-title text-white">New Trends<br><span><strong>spring 2019</strong></span></div><!-- End .banner-title -->
                                                </div><!-- End .banner-content -->
                                            </a>
                                        </div><!-- End .banner -->
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu megamenu-sm -->
                        </li>
                    </ul>
                </nav><!-- End .main-nav -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                    <form action="#" method="get">
                        <div class="header-search-wrapper">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="q" id="q" placeholder="Search in..." required>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->

                <div class="dropdown cart-dropdown">
                    <a href="{{ url('cart-show') }}" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count" id="cart-count">
                             0
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-cart-products" id="product_show">

                            {{-- @foreach ( $carts as $cart) --}}

                            {{-- @endforeach --}}


                            {{-- <div class="product">
                                <div class="product-cart-details">
                                    <h4 class="product-title">
                                        <a href="product.html">Blue utility pinafore denim dress</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span>
                                        x $76.00
                                    </span>
                                </div><!-- End .product-cart-details -->

                                <figure class="product-image-container">
                                    <a href="product.html" class="product-image">
                                        <img src="{{ asset('public/frontend/assets/images/products/cart/product-2.jpg') }}" alt="product">
                                    </a>
                                </figure>
                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                            </div><!-- End .product --> --}}
                        </div><!-- End .cart-product -->

                        <div class="dropdown-cart-total">
                            <span>Total</span>

                            <span class="cart-total-price">${{ number_format($total_cart_sum, 2) }}</span>
                        </div><!-- End .dropdown-cart-total -->

                        <div class="dropdown-cart-action">
                            <a href="{{ url('/cart-show') }}" class="btn btn-primary">View Cart</a>
                            <a href="checkout.html" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
                        </div>

                    </div>
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header>



@push('scripts')
    <script>
        $(document).ready(function(){
            
            function headerCart(){
                $.ajax({
                method: "GET",
                url: "{{ route('getCart.data') }}",
                dataType: "json",
                success: function(res){
                    console.log(res.success);
                    $('#cart-count').html(res.success.length);

                    var carts = '';
                    var totalAmount = 0;

                    if (res.success.length > 0) { 
                        $.each(res.success, function(index, item){
                            totalAmount += item.price * item.qty;

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
                                            <img src="`+ item.thumbnail +`" alt="product">
                                        </a>
                                    </figure>
                                    <button class="btn-remove" data-id="`+item.cart_id +` title="Remove Product"><i class="icon-close"></i></button>
                                </div>`;
                            });
                        }  
                        else {
                            carts = `
                            <div class="alert alert-danger text-center" role="alert">
                                There is no data here!
                            </div>`;

                            totalAmount = 0;
                        }

                      $('#product_show').html(carts);
                      $('#cart-total-price').html('$' + totalAmount.toFixed(2));
                    },
                    
                    error: function (err){
                    console.log(err);
                    }
              })
            }

            // initially data show
            headerCart();


            // delete cart data
            $(document).on('click', '.btn-remove', function(){
                var id = $(this).data('id');

                 $.ajax({
                     method: "POST",
                     url: "{{ route('delete.cart') }}",
                     data: { id: id },
                     dataType: "json",
                     success: function(data){
                        console.log(data);

                        // cart_section_data();
                        headerCart();
                     },
                     error: function(err){
                        console.log(err);
                     }
               })
            })

        })
    </script>
@endpush


