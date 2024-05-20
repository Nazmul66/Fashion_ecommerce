@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - Product create Page </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Product Create Page</h5>
               <a href="{{ route('product.manage') }}">
                  <button class="btn btn-primary">Manage Product</button>
               </a>
           </div>


            <div class=" px-3">
              <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col mb-3">
                        <label for="title" class="form-label">Product Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="title" class="form-label">Product Sku Code<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sku_code" name="sku_code" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="Unit" class="form-label">Unit <span class="text-danger"> *</span></label>
                        <select class="form-select" id="unit" name="unit" required>
                            <option selected="" disabled="">Select the Unit</option>

                            <option selected="" value="pcs">Pcs</option>
                            <option value="kg">Kg</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="product_varient" class="form-label">Product Varient <span class="text-danger"> *</span></label>
                        <select class="form-select" id="product_varient">
                            <option selected value="simple">Simple Product</option>
                            <option value="variation">Product Variation</option>
                        </select>
                        <p class="text-danger mb-0">Note: adjust products variation</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="cat_id" class="form-label">Category Name<span class="text-danger">*</span></label>
                        <select class="form-select category_select" id="cat_id" name="cat_id">
                            <option selected="" disabled="">Select the category name</option>

                            @foreach ($categories as $category)
                               <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="subCat_id" class="form-label">SubCategory Name<span class="text-danger">*</span></label>
                        <select class="form-select subCategory_select" id="subCat_id" name="subCat_id">
                            <option selected="" disabled="">Select the subCategory name</option>

                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="brand_id" class="form-label">Brand Name<span class="text-danger">*</span></label>
                        <select class="form-select subCategory_select" id="brand_id" name="brand_id">
                            <option selected="" disabled="">Select the brand name</option>

                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="purchase_price" class="form-label">Old Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="purchase_price" name="purchase_price" placeholder="Write Here..........">
                    </div>
                </div>

                <div class="row">

                    <div class="col mb-3">
                        <label for="Selling_price" class="form-label">Selling Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="Selling_price" name="selling_price" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="discount_price" class="form-label">Discount Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="discount_price" name="discount_price" placeholder="Write Here..........">
                    </div>

                    <div class="col mb-3">
                        <label for="product_featured" class="form-label">Featured Product<span class="text-danger"> *</span></label>
                        <select class="form-select" id="product_featured" name="is_featured">
                            <option selected="" value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="product_trendy" class="form-label">Trendy Product<span class="text-danger"> *</span></label>
                        <select class="form-select" id="product_trendy" name="is_trendy">
                            <option selected="" value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="product_promotion" class="form-label">Promotion Product<span class="text-danger"> *</span></label>
                        <select class="form-select" id="product_promotion" name="is_promotion">
                            <option selected="" value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="todays_deal" class="form-label">Todays Deal<span class="text-danger"> *</span></label>
                        <select class="form-select" id="todays_deal" name="todays_deal">
                            <option selected="" value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="product_tags" class="form-label">Product Tags<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product_tags" name="product_tags" placeholder="Write Here..........">
                    </div>
                </div>

                <div class="col-lg-12 color_field">
                    <label class="form-label">Color <span class="text-danger">*</span></label>

                    <div class="mt-2 mb-3">
                        @foreach ($colors as $color)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{ $color->id }}" name="color[]" id="Red">
                                <label class="form-check-label" for="Red" >{{ $color->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-12 size_field">

                    <label class="form-label mb-3">Size <span class="text-danger">*</span></label>

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
                                <tr>
                                    <td>
                                        <input type="text" class="form-control size_name" disabled name="size_name[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control size_price" disabled name="size_price[]">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Image</label>
                            <input class="form-control" type="file" name="thumbnail" accept="image/png, image/jpeg, image/jpg, image/webp" id="thumbnail">
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Add Multiple Image File</label>
                            <input class="form-control" type="file" multiple name="images[]" accept="image/png, image/jpeg, image/jpg, image/webp" id="formFile">
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control description" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="3"></textarea>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="add_information" class="form-label">Additional & Information <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="add_information" name="add_information" rows="3"></textarea>
                </div>

                <div class="col-lg-12 mb-3">
                    <label for="shipping_returns" class="form-label">Shipping & Returns <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="shipping_returns" name="shipping_returns" rows="3"></textarea>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status">
                        <option selected="" disabled="">Select the status name</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
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
      // select 2 all functions call
        $('.category_select').select2();
        $('.subCategory_select').select2();
        $('.brand_select').select2();

      $('#product_varient').on('change', function(){
          let setup = $(this).val();

          if(setup === 'simple'){
              $('.size_field').css('display', 'none');
              $('.color_field').css('display', 'none');
              $('.size_name').attr('disabled', true)
              $('.size_price').attr('disabled', true)
          }
          else if(setup === 'variation'){
              $('.size_field').css('display', 'block');
              $('.color_field').css('display', 'block');
              $('.size_name').attr('disabled', false)
              $('.size_price').attr('disabled', false)
          }
      })

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
    $('#cat_id').on('change', function(){
        var id = $(this).val();

            $.ajax({
                method : 'POST',
                url : "{{ route('admin.get.category') }}",
                data: { data_id : id },
                success : function (data){

                    var sub_cat = data.data;
                    $('#subCat_id').empty();

                    if( data.status === "success" ){
                        let options = '';

                        sub_cat.forEach((row) => {
                            options += `<option value="${row.id}">${row.name}</option>`;
                        });

                        $('#subCat_id').append(options);
                    }
                    else{
                        $('#subCat_id').append('<option disabled="">No data here</option>');
                    }
                },
                error : function(err){
                    console.log(err)
                }
            });
        })
    });
</script>

@endpush
