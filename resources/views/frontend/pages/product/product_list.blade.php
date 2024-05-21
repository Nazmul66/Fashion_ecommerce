                
<div class="products mb-3">
    <div class="row justify-content-center">

    @foreach ($allProducts as $allProduct)

        <div class="col-6 col-md-4 col-lg-4">
            <div class="product product-7 text-center">
                <figure class="product-media">
                    <span class="product-label label-new">New</span>
                    <a href="product.html">
                        <img src="{{ asset($allProduct->thumbnail) }}" alt="Product image" class="product-image">
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
                        <a href="{{ route('get.category', $allProduct->cat_slug . '/' .  $allProduct->subCat_slug) }}">
                            {{ $allProduct->subCat_name }}
                        </a>
                    </div><!-- End .product-cat -->
                    <h3 class="product-title"><a href="{{ route('product.details', $allProduct->slug) }}">{{ $allProduct->title }}</a></h3><!-- End .product-title -->
                    <div class="product-price">
                        ${{ number_format($allProduct->selling_price, 2) }}
                    </div><!-- End .product-price -->
                    <div class="ratings-container">
                        <div class="ratings">
                            <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
                        </div><!-- End .ratings -->
                        <span class="ratings-text">( 2 Reviews )</span>
                    </div><!-- End .rating-container -->
                </div><!-- End .product-body -->
            </div><!-- End .product -->
        </div>

    @endforeach
    </div>
</div>

{{ $allProducts->links() }}