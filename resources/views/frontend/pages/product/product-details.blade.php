@php
    $cart = App\Models\Cart::productAddToCart($singleProduct->id);
    if( !empty($cart) ){
        $availableStock = App\Models\Product::where('id', $cart->product_id)->value('quantity');
    }
@endphp

@extends('frontend.layout.template')

@push('meta-title')
    ECommerce - {{ $singleProduct->slug }} product
@endpush

@section('body-content')

<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    <div class="container d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('get.category', $singleProduct->cat_slug . '/' . $singleProduct->subCat_slug) }}">{{ $singleProduct->cat_name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $singleProduct->subCat_name }}</li>
        </ol>
    </div>
</nav>

<div class="page-content">
    <div class="container">
        <div class="product-details-top">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-gallery product-gallery-vertical">
                        <div class="row">
                            <figure class="product-main-image">
                                <img id="product-zoom" src="{{ asset($singleProduct->thumbnail) }}" data-zoom-image="{{ asset($singleProduct->thumbnail) }}" alt="product image">

                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                    <i class="icon-arrows"></i>
                                </a>
                            </figure>

                            <div id="product-zoom-gallery" class="product-image-gallery">
                                
                                <a class="product-gallery-item active" href="#" data-image="{{ asset($singleProduct->thumbnail) }}" data-zoom-image="{{ asset($singleProduct->thumbnail) }}">
                                    <img src="{{ asset($singleProduct->thumbnail) }}" alt="product side">
                                </a>

                                @foreach (App\Models\ProductImages::getAllImageRecord( $singleProduct->id ) as $image)
                                    <a class="product-gallery-item active" href="#" data-image="{{ asset($image->product_path . $image->product_name) }}" data-zoom-image="{{ asset($image->product_path . $image->product_name) }}">
                                        <img src="{{ asset($image->product_path . $image->product_name) }}" alt="{{ $image->product_name }}">
                                    </a>
                                @endforeach
 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="product-details">
                        <h1 class="product-title mb-2">{{ $singleProduct->title }}</h1>

                        <a href="{{ route('get.category', $singleProduct->cat_slug . '/' . $singleProduct->subCat_slug) }}" class="bg-info text-white p-3" style="border-radius: 10px; font-weight: 500">{{ $singleProduct->cat_name }} Category</a>

                        <div class="mt-2">
                            <span style="font-size: 18px; font-weight: 600; color: #c96">Quantity:
                                @if( !empty($cart) ) 
                                    @if ( $cart->product_qty == $availableStock )
                                       <span class="badge text-white bg-danger">Stock Out</span>
                                    @else
                                       {{ $singleProduct->quantity - $cart->product_qty }} {{ $singleProduct->unit }}
                                    @endif
                                @else
                                    {{ $singleProduct->quantity }} {{ $singleProduct->unit }}
                                @endif
                            </span>
                        </div>

                        <div class="ratings-container mt-2">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 80%;"></div>
                            </div>

                            <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                        </div>


                        <div class="product-price">
                        @if( !empty($cart) )
                            $<span id="product_price">{{ number_format($cart->product_price, 2) }}</span>
                        @else
                            @if ( !empty($singleProduct->discount_price) )
                                $<span id="product_price">{{ number_format($singleProduct->discount_price, 2) }}</span>

                                 <span class="text-danger" style="font-size: 15px; margin-left: 10px;"><del>$<span>{{ number_format($singleProduct->selling_price, 2) }}</span></del></span>   
                            @else
                                $<span id="product_price">{{ number_format($singleProduct->selling_price, 2) }}</span>
                            @endif
                        @endif

                        </div><!-- End .product-price -->

                        <div class="product-content">
                            <p>{{ Str::substr(strip_tags($singleProduct->short_description), 0, 180)}}........</p>
                        </div><!-- End .product-content -->

                    <form method="post" action="{{ route('product.cart') }}">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $singleProduct->id }}">

                        @if ( App\Models\ProductColor::getAllColorRecord($singleProduct->id)->count() > 0 )
                            <div class="details-filter-row details-row-size">
                                <label for="color">Color:</label>

                                <div class="select-custom">
                                    <select name="color_id" id="color" class="form-control" style="cursor: pointer;" required>
                                        <option value="" selected disabled>Select a color</option>

                                        @if( !empty($cart) ) 
                                            @foreach (App\Models\ProductColor::getAllColorRecord($singleProduct->id) as $color)
                                              {{ $color->count() }}
                                                <option value="{{ $color->color_id }}" @if( $cart->color_id == $color->id ) selected @endif>{{ $color->color_name }}</option>
                                            @endforeach
                                        @else
                                            @foreach (App\Models\ProductColor::getAllColorRecord($singleProduct->id) as $color)
                                                <option value="{{ $color->color_id }}">{{ $color->color_name }}</option>
                                            @endforeach
                                        @endif 

                                    </select>
                                </div>
                            </div>
                        @endif


                        @if ( App\Models\Product_size::getAllSizeRecord($singleProduct->id)->count() > 0 )
                            <div class="details-filter-row details-row-size">
                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select name="size_id" id="size" class="form-control" style="cursor: pointer;" required>
                                        <option value="" selected="" disabled>Select a size</option>

                                        @if( !empty($cart) ) 
                                            @foreach (App\Models\Product_size::getAllSizeRecord($singleProduct->id) as $size)
                                                <option data-price="{{ $size->price }}" value="{{ $size->id }}" @if( $cart->size_id == $size->id ) selected @endif>@if( $size->name ) {{ $size->name }} ( {{ number_format($size->price) }} ) @endif</option>
                                            @endforeach

                                        @else
                                            @foreach (App\Models\Product_size::getAllSizeRecord($singleProduct->id) as $size)
                                                <option data-price="{{ $size->price }}" value="{{ $size->id }}">@if( $size->name ) {{ $size->name }} ( {{ number_format($size->price) }} ) @endif</option>
                                            @endforeach
                                        @endif 

                                    </select>
                                </div>
                            </div>
                        @endif
                        

                        <div class="details-filter-row details-row-size">
                            <label for="qty">Qty:</label>
                            <div class="product-details-quantity">
                                <input type="number" id="qty" name="product_qty" class="form-control" value="1" min="1" max="10" step="1" data-decimals="0" required="" style="display: none;">
                            </div>
                        </div>

                        <div class="product-details-action">
                            @if( !empty($cart) ) 
                               @if( $cart->product_qty == $availableStock )
                                    <button type="submit" class="btn-product btn-cart" disabled style="cursor: not-allowed" ><span>Stock Out</span></button>
                                @else
                                   <button type="submit" class="btn-product btn-cart"><span>add to cart</span></button>
                               @endif 
                            @else
                               <button type="submit" class="btn-product btn-cart"><span>add to cart</span></button>
                            @endif


                            <div class="details-action-wrapper">
                                <button type="submit" style="border:none; background: none">
                                    <a href="" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
                                </button>
                                {{-- <button type="submit" class="btn-product btn-compare" title="Compare"><span>Add to Compare</span></button> --}}
                            </div>
                        </div>
                    </form>

                        <div class="product-details-footer">
                            <div class="product-cat">
                                <span>Products Tag : {{ $singleProduct->tags }}</span>
                            </div>

                            <div class="social-icons social-icons-sm">
                                <span class="social-label">Share:</span>
                                <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                            </div>
                        </div><!-- End .product-details-footer -->
                    </div><!-- End .product-details -->
                </div>
            </div>
        </div><!-- End .product-details-top -->

        <div class="product-details-tab">
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping &amp; Returns</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                </li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane fade active show" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                    <div class="product-desc-content">

                        {!! $singleProduct->description !!}

                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">

                        {!! $singleProduct->additional_information !!}

                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                    <div class="product-desc-content">
                       
                        {!! $singleProduct->shipping_returns !!}

                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                    <div class="reviews">
                        <h3>Reviews (2)</h3>
                        <div class="review">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <h4><a href="#">Samanta J.</a></h4>
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                    </div><!-- End .rating-container -->
                                    <span class="review-date">6 days ago</span>
                                </div><!-- End .col -->
                                <div class="col">
                                    <h4>Good, perfect size</h4>

                                    <div class="review-content">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores assumenda asperiores facilis porro reprehenderit animi culpa atque blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit beatae quae voluptas!</p>
                                    </div><!-- End .review-content -->

                                    <div class="review-action">
                                        <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                        <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                    </div><!-- End .review-action -->
                                </div><!-- End .col-auto -->
                            </div><!-- End .row -->
                        </div><!-- End .review -->

                        <div class="review">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <h4><a href="#">John Doe</a></h4>
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                    </div><!-- End .rating-container -->
                                    <span class="review-date">5 days ago</span>
                                </div><!-- End .col -->
                                <div class="col">
                                    <h4>Very good</h4>

                                    <div class="review-content">
                                        <p>Sed, molestias, tempore? Ex dolor esse iure hic veniam laborum blanditiis laudantium iste amet. Cum non voluptate eos enim, ab cumque nam, modi, quas iure illum repellendus, blanditiis perspiciatis beatae!</p>
                                    </div><!-- End .review-content -->

                                    <div class="review-action">
                                        <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                        <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                    </div><!-- End .review-action -->
                                </div><!-- End .col-auto -->
                            </div><!-- End .row -->
                        </div><!-- End .review -->
                    </div><!-- End .reviews -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .product-details-tab -->



    <!-- Related Product show -->
    @if ( $gerRelatedProducts->count() > 0 )    
        <h2 class="title text-center mb-4">You May Also Like</h2>

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow owl-loaded owl-drag" data-toggle="owl" data-owl-options="{
                    &quot;nav&quot;: false,
                    &quot;dots&quot;: true,
                    &quot;margin&quot;: 20,
                    &quot;loop&quot;: false,
                    &quot;responsive&quot;: {
                        &quot;0&quot;: {
                            &quot;items&quot;:1
                        },
                        &quot;480&quot;: {
                            &quot;items&quot;:2
                        },
                        &quot;768&quot;: {
                            &quot;items&quot;:3
                        },
                        &quot;992&quot;: {
                            &quot;items&quot;:4
                        },
                        &quot;1200&quot;: {
                            &quot;items&quot;:4,
                            &quot;nav&quot;: true,
                            &quot;dots&quot;: false
                        }
                    }
                }">
                <!-- End .product -->


            <div class="owl-stage-outer">
                <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1485px;">

                    @foreach ($gerRelatedProducts as $relatedPrdt)
                        <div class="owl-item active" style="width: 277px; margin-right: 20px;">
                            <div class="product product-7 text-center">
                                <figure class="product-media">
                                    <a href="product.html">
                                        <img src="{{ asset( $relatedPrdt->thumbnail ) }}" alt="Product image" class="product-image">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                        <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                        <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                    </div><!-- End .product-action-vertical -->

                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                    </div><!-- End .product-action -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="{{ route('get.category', $relatedPrdt->cat_slug . '/' .  $relatedPrdt->subCat_slug) }}">
                                            {{ $relatedPrdt->subCat_name }}
                                        </a>
                                    </div>
                                    <h3 class="product-title"><a href="{{ route('get.category', $relatedPrdt->slug) }}">{{ $relatedPrdt->title }}</a></h3>
                                    <div class="product-price">

                                        @if ( !empty($relatedPrdt->discount_price) )
                                        ${{ number_format($relatedPrdt->discount_price, 2) }}

                                        <span class="text-danger" style="font-size: 15px; margin-left: 10px;"><del>${{ number_format($relatedPrdt->selling_price, 2) }}</del></span>   
                                        @else
                                            ${{ number_format($relatedPrdt->selling_price, 2) }}
                                        @endif

                                    </div>

                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <span class="ratings-text">( 2 Reviews )</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


                <div class="owl-nav">
                    <button type="button" role="presentation" class="owl-prev disabled"><i class="icon-angle-left"></i></button>
                    <button type="button" role="presentation" class="owl-next"><i class="icon-angle-right"></i></button>
                </div>
                <div class="owl-dots disabled"></div>

            </div><!-- End .owl-carousel -->
        @endif
        <!-- Related Product show -->
    </div><!-- End .container -->
</div>

@endsection


@push('scripts')

     <script src="{{ asset('public/frontend/assets/js/jquery.elevateZoom.min.js') }}"></script>

@endpush


@push('scripts')

  <script>
      $(document).ready(function(){
          $('#size').change(function(){
            var data = $('option:selected', this).data('price')
            //  console.log(data);

            var main_price = '{{ $singleProduct->selling_price}}';

            var total = parseFloat(data) + parseFloat(main_price);
            $('#product_price').html(total.toFixed(2));
          })
      })
  </script>

@endpush
