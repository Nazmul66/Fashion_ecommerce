@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - Product Edit Page </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Product Edit Page</h5>
               <a href="{{ route('product.manage') }}">
                  <button class="btn btn-primary">Manage Product</button>
               </a>
           </div>


            <div class=" px-3">
              <form method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col mb-3">
                        <label for="title" class="form-label">Product Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" value="{{ $product->title }}" name="title" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="title" class="form-label">Product Sku Code<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sku_code" value="{{ $product->sku_code }}" name="sku_code" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="Unit" class="form-label">Unit <span class="text-danger"> *</span></label>
                        <select class="form-select" id="unit" name="unit" required>
                            <option selected="" disabled="">Select the Unit</option>

                            <option value="pcs" @if( $product->unit === 'pcs' ) selected @endif>Pcs</option>
                            <option value="kg" @if( $product->unit === 'kg' ) selected @endif>Kg</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cat_id" class="form-label">Category Name<span class="text-danger">*</span></label>
                        <select class="form-select category_select" id="cat_id" name="cat_id">
                            <option selected="" disabled="">Select the category name</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if( $product->category_id === $category->id ) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4  mb-3">
                        <label for="subCat_id" class="form-label">SubCategory Name<span class="text-danger">*</span></label>
                        <select class="form-select subCategory_select" id="subCat_id" name="subCat_id">
                            <option selected="" disabled="">Select the subCategory name</option>

                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @if( $product->subCategory_id === $subCategory->id ) selected @endif>{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="brand_id" class="form-label">Brand Name<span class="text-danger">*</span></label>
                        <select class="form-select subCategory_select" id="brand_id" name="brand_id">
                            <option selected="" disabled="">Select the brand name</option>

                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @if( $product->brand_id === $brand->id ) selected @endif>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="purchase_price" class="form-label">Purchase Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="purchase_price" value="{{ $product->purchase_price }}" name="purchase_price" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="selling_price" class="form-label">Selling Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="selling_price" value="{{ $product->selling_price }}" name="selling_price" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="discount_price" class="form-label">Discount Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="discount_price" value="{{ $product->discount_price }}" name="discount_price" placeholder="Write Here..........">
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="product_featured" class="form-label">Featured Product<span class="text-danger"> *</span></label>
                        <select class="form-select" id="product_featured" name="is_featured">
                            <option selected="" value="1" @if( $product->is_featured == 1 ) selected @endif>Active</option>
                            <option value="0" @if( $product->is_featured == 0 ) selected @endif>InActive</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="product_trendy" class="form-label">Trendy Product<span class="text-danger"> *</span></label>
                        <select class="form-select" id="product_trendy" name="is_trendy">
                            <option selected="" value="1" @if( $product->is_trendy == 1 ) selected @endif>Active</option>
                            <option value="0" @if( $product->is_trendy == 0 ) selected @endif>InActive</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="product_promotion" class="form-label">Promotion Product<span class="text-danger"> *</span></label>
                        <select class="form-select" id="product_promotion" name="is_promotion">
                            <option selected="" value="1" @if( $product->is_promotion == 1 ) selected @endif>Active</option>
                            <option value="0" @if( $product->is_promotion == 0 ) selected @endif>InActive</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="todays_deal" class="form-label">Todays Deal<span class="text-danger"> *</span></label>
                        <select class="form-select" id="todays_deal" name="todays_deal">
                            <option selected="" value="1" @if( $product->todays_deal == 1 ) selected @endif>Active</option>
                            <option value="0" @if( $product->todays_deal == 0 ) selected @endif>InActive</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="product_tags" class="form-label">Product Tags<span class="text-danger">*</span></label>
                        <input type="text" value="{{ $product->tags }}" class="form-control" id="product_tags" name="product_tags" placeholder="Write Here..........">
                    </div>
                </div>

                @if ( $productColors->count() > 0 )
                    <div class="col-lg-12">
                        <label class="form-label">Color <span class="text-danger">*</span></label>

                        <div class="mt-2 mb-3">
                            @foreach ($colors as $color)
                                @php
                                    $checked = '';
                                @endphp

                                @foreach ( $productColors as $productColor )
                                    @if ( $color->id === $productColor->color_id )
                                    @php
                                        $checked = 'checked';
                                    @endphp
                                    @endif
                                @endforeach

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" {{ $checked }} value="{{ $color->id }}" name="color[]" id="Red">
                                <label class="form-check-label" for="Red" >{{ $color->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                @if ( $productSizes->count() > 0 )
                    <div class="col-lg-12">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label mb-0">Size <span class="text-danger">*</span></label>
                            <button type="button" class="btn btn-info">Add</button>
                        </div>

                        <div class="table-responsive text-nowrap mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price ($)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody class="table-border-bottom-0 table_extend">
                                    @foreach ($productSizes as $productSize)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value="{{ $productSize->name }}" name="size_name[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="{{ $productSize->price }}" name="size_price[]">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif


                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail Image</label>
                        <input class="form-control" type="file" name="thumbnail" accept="image/png, image/jpeg, image/jpg, image/webp" id="thumbnail">
                        @if ( !empty( $product->thumbnail ) )
                            <img src="{{ asset( $product->thumbnail ) }}" alt="{{ $product->slug }}" style="width: 150px;">
                        @endif
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Add Multiple Image File</label>

                        <div class="d-flex gap-3 mb-3">
                            @foreach ($productImages as $productImage)
                                @if ( !empty($productImage) )
                                  <div class="position-relative">
                                     <img src="{{ asset($productImage->product_path . $productImage->product_name) }}" alt="" style="width: 150px;">
                                     <a href="{{ route('product.destroyImage', $productImage->id ) }}" class="delete_image_btn"><i class='bx bx-x text-danger'></i></a>
                                  </div>
                                @endif
                            @endforeach
                        </div>

                        <input class="form-control" type="file" name="images[]" multiple accept="image/png, image/jpeg, image/jpg, image/webp" id="formFile">
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control description" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="3">{{ $product->short_description }}</textarea>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="add_information" class="form-label">Additional & Information <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="add_information" name="add_information" rows="3">{{ $product->additional_information }}</textarea>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="shipping_returns" class="form-label">Shipping & Returns <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="shipping_returns" name="shipping_returns" rows="3">{{ $product->shipping_returns }}</textarea>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status">
                        <option selected="" disabled="">Select the status name</option>
                        <option value="1" @if( $product->status === 1 ) selected @endif>Active</option>
                        <option value="0" @if( $product->status === 0 ) selected @endif>InActive</option>
                    </select>
                </div>

                 <button type="submit" class="btn btn-primary mb-3">Submit</button>
             </form>
           </div>
         </div>
      </div>
   </div>

@endsection

@push('script')

<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector('#description' ),{
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
        })
        .catch( error => {
            console.error( error );
        });
</script>


<script>
    ClassicEditor
        .create( document.querySelector('#short_description' ),{
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
        })
        .catch( error => {
            console.error( error );
        });
</script>


<script>
    ClassicEditor
        .create( document.querySelector('#add_information' ),{
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
        })
        .catch( error => {
            console.error( error );
        });
</script>

<script>
    ClassicEditor
        .create( document.querySelector('#shipping_returns' ),{
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
        })
        .catch( error => {
            console.error( error );
        });
</script>

<script>
    $(document).ready(function(){
        $('.category_select').select2();
        $('.subCategory_select').select2();
        $('.brand_select').select2();
    });
</script>

<script>
    let table = new DataTable('#productTable');


    $(document).ready(function(){

    // add new input rows
    $(document).on("click", ".btn-info", function(){
            $('.table_extend').append(`
            <tr>
                <td>
                    <input type="text" class="form-control" name="size_name[]">
                </td>
                <td>
                    <input type="number" class="form-control" name="size_price[]">
                </td>
                <td>
                    <button type="button" class="btn btn-danger">Remove</button>
                </td>
            </tr>
        `);
    });


    // delete all single input rows
    $(document).on("click", ".btn-danger", function(){
        $(this).closest("tr").remove();
    })

    // category select that filter all subcategory data
    // $('#cat_id').on('change', function(){
    //     var id = $(this).val();

    //         $.ajax({
    //             method : 'POST',
    //             url : "{{ route('admin.get.category') }}",
    //             data: { data_id : id },
    //             success : function (data){

    //                 var sub_cat = data.data;
    //                 $('#subCat_id').empty();

    //                 if( data.status === "success" ){
    //                     let options = '';

    //                     sub_cat.forEach((row) => {
    //                         options += `<option value="${row.category_id}">${row.name}</option>`;
    //                     });

    //                     $('#subCat_id').append(options);
    //                 }
    //                 else{
    //                     $('#subCat_id').append('<option disabled="">No data here</option>');
    //                 }
    //             },
    //             error : function(err){
    //                 console.log(err)
    //             }
    //         });
    //     })
    });
</script>

@endpush
