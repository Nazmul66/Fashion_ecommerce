@extends('frontend.layout.template')

@push('meta-title')
    ECommerce -
        @if (!empty($getSubCategory))
            {{  $getSubCategory->slug }}
        @else
           {{ $getCategory->slug }}
        @endif
    Product
@endpush

@section('body-content')

<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
    <div class="container">
        <h1 class="page-title"> 
            @if (!empty($getSubCategory))
               {{  $getSubCategory->name }}
            @else
               {{ $getCategory->name }}
            @endif
            <span>Shop</span>
        </h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            @if ( !empty($getSubCategory) )
               <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('get.category', $getCategory->slug) }}">{{ $getCategory->name }}</a></li>
               <li class="breadcrumb-item active" aria-current="page">{{ $getSubCategory->name }}</li>
            @else
               <li class="breadcrumb-item active" aria-current="page">{{ $getCategory->name }}</li>
            @endif
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="toolbox">
                    <div class="toolbox-left">
                        <div class="toolbox-info">
                            Showing <span><span id="product_count">{{ $allProducts->count() }}</span> of {{ $totalProductCount }}</span> Products
                        </div><!-- End .toolbox-info -->
                    </div><!-- End .toolbox-left -->

                    <div class="toolbox-right">
                        <div class="toolbox-sort">
                            <label for="sortby">Sort by:</label>
                            <div class="select-custom">
                                <select name="sortby" id="sortby" class="form-control changeSortBy">
                                    <option value="" selected="" disabled>Select</option>
                                    <option value="asc">Name (Asc)</option>
                                    <option value="desc">Name (Desc)</option>
                                    <option value="lh">Price ( Low - High )</option>
                                    <option value="hl">Price ( High - Low )</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- all product are will be shown --}}
                <div id="getProductAjax">
                    @include('frontend.pages.product.product_list')
                </div>

            </div><!-- End .col-lg-9 -->


            <aside class="col-lg-3 order-lg-first">

                <!-- All Filter section in here -->
                <form id="filterForm" method="post">
                    @csrf
                    
                    <input type="hidden" name="old_subCategory_id" value="{{ !empty($getSubCategory) ? $getSubCategory->id : '' }}" > 
                    <input type="hidden" name="old_Category_id" value="{{ !empty($getCategory) ? $getCategory->id : '' }}"> 

                    <input type="hidden" name="subCategory_id" id="category_id"> 
                    <input type="hidden" name="brand_id" id="brand_id"> 
                    <input type="hidden" name="color_id" id="color_id"> 
                    <input type="hidden" name="sortBy" id="sortBy"> 
                    <input type="hidden" name="start_price" id="start_price"> 
                    <input type="hidden" name="end_price" id="end_price"> 
                </form>
                <!-- All Filter section in here -->

                <div class="sidebar sidebar-shop">
                    <div class="widget widget-clean">
                        <label>Filters:</label>
                        <a href="#" class="sidebar-filter-clear" id="clear_all">Clean All</a>
                    </div><!-- End .widget widget-clean -->

                    <!-- Category Filter section start -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                Category
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-1">
                            <div class="widget-body">
                                <div class="filter-items filter-items-count">

                                  @foreach ($subCategoryFilter as $value)
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input changeCategory" value="{{ $value->id }}" id="{{ $value->id }}">
                                            <label class="custom-control-label" for="{{ $value->id }}">{{ $value->name }}</label>
                                        </div>
                                        
                                        @php
                                           $total_count = App\Models\Product::where('subCategory_id', $value->id)->where('status', 1)->where('is_delete', 0)->count();
                                        @endphp
                                        <span class="item-count">{{ $total_count }}</span>
                                    </div>
                                  @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Category Filter section end -->

                    <!-- Price Range Filter section start -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                Price
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-5">
                            <div class="widget-body">
                                <div class="filter-price">
                                    <div class="filter-price-text">
                                        Price Range:
                                        <span id="filter-price-range"></span>
                                    </div>

                                    <div id="price-slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Price Range Filter section end -->

                    <!-- Color Filter section start -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                Colour
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-3">
                            <div class="widget-body">
                                <div class="filter-colors">
                                    
                                    @foreach ($getColors as $value)
                                      <a href="javascript:;" class="changeColor" id="{{ $value->id }}" data-val="0" style="background: {{ $value->code }};">
                                        <span class="sr-only">{{ $value->name }}</span>
                                      </a>
                                    @endforeach
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Color Filter section end -->

                    <!-- Brand Filter section start -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                Brand
                            </a>
                        </h3>

                        <div class="collapse show" id="widget-4">
                            <div class="widget-body">
                                <div class="filter-items">

                                  @foreach ($getBrands as $value)
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input changeBrand" value="{{ $value->id }}" id="{{ $value->id }}c">
                                            <label class="custom-control-label" for="{{ $value->id }}c">{{ $value->name }}</label>
                                        </div>
                                    </div>
                                  @endforeach

                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div>
                    <!-- Brand Filter section end -->

                </div><!-- End .sidebar sidebar-shop -->
            </aside><!-- End .col-lg-3 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div><!-- End .page-content -->

@endsection


@push('scripts')

<script>
    $(document).ready(function(){

        //____ Clear all selecting data ____//
        $('#clear_all').click(function(){
            $('#category_id').val('');
            $('#brand_id').val('');
            $('#color_id').val('');
            $('#sortBy').val('');
            filterForms();
        })

        //____ for get Category id ____//
        $('.changeCategory').change(function(){
            var ids = '';
            $('.changeCategory').each(function(){
               if(this.checked){
                   var id = $(this).val();
                //    console.log(id);
                   ids += id + ',';
               }
            })
            // console.log(ids);
            $('#category_id').val(ids);
            filterForms()
        })


        //____ for get Brand id ____//
         $('.changeSortBy').change(function(){
            var id = $(this).val();
            // console.log(id);

            $('#sortBy').val(id);
            filterForms()
         })



        //____ for get Brand id ____//
        $('.changeBrand').change(function(){
            var ids = '';
            $('.changeBrand').each(function(){
               if(this.checked){
                   var id = $(this).val();
                //    console.log(id);
                   ids += id + ',';
               }
            })
            // console.log(ids);
            $('#brand_id').val(ids);
            filterForms()
        })


        //____ for get Color id ____//
        $('.changeColor').click(function(){
            var id     = $(this).attr('id');
            var status = $(this).attr('data-val');

            if( status == 0 ){
                $(this).attr('data-val', 1);
                $(this).addClass('active_color');
            }
            else{
                $(this).attr('data-val', 0);
                $(this).removeClass('active_color');
            }
            
            // console.log(id, status);

            var ids = ''; 
            $('.changeColor').each(function(){
                var id = $(this).attr('id');
                var status = $(this).attr('data-val');

                if( status == 1 ){
                    // console.log(id);
                    ids += id + ',';
                }
            })
            //  console.log(ids);
             $('#color_id').val(ids);
             filterForms()
        })


        //  form data filtering
        function filterForms(){
            // console.log('hi');
            $.ajax({
                method : "POST",
                url : "{{ route('get.product.filter') }}",
                data : $('#filterForm').serialize(),
                dataType : 'json',
                success : function(data){
                    console.log(data.total);
                   $('#product_count').text(data.total);
                   $('#getProductAjax').html(data.success);
                },
                error : function(data){

                }
            });
        }


        var i = 0;
        // Slider For category pages / filter price
        if ( typeof noUiSlider === 'object' ) {
            var priceSlider  = document.getElementById('price-slider');

            noUiSlider.create(priceSlider, {
                start: [ 0, 800 ],
                connect: true,
                step: 2,
                margin: 100,
                range: {
                    'min': 0,
                    'max': 1000
                },
                tooltips: true,
                format: wNumb({
                    decimals: 0,
                    prefix: '$'
                })
            });

            // Update Price Range
            priceSlider.noUiSlider.on('update', function( values, handle ){
                // console.log(values);
                var first_price = values[0];
                var last_price = values[1];
                $('#start_price').val(first_price);
                $('#end_price').val(last_price);
                $('#filter-price-range').text(values.join(' - '));

                /// this condition is for that automatically this slider can request the ajax call ( 2 time ) but you need to condition this type, so you can not call the data automatically like below :-
                if( i == 0 || i == 1 ){
                     i++
                }
                else{
                    filterForms();
                }
            });
        }

})



</script>

@endpush
