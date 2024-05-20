@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - Product Manage Page </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Product Manage</h5>
               <a href="{{ route('product.create') }}">
                   <button class="btn btn-primary">Add Product</button>
               </a>
           </div>

            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="productTable">
                  <thead>
                    <tr>
                      <th>#SL.</th>
                      <th>Title</th>
                      <th>Image</th>
                      <th>Category Name</th>
                      <th>SubCategory Name</th>
                      <th>Brand Name</th>
                      <th>Purchase Price</th>
                      <th>Discount Price</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($products as $row => $product)
                            <tr>
                                <td>{{ $row + 1 }}</td>
                                <td><strong>{{ $product->title }}</strong></td>
                                <td>
                                    @if ( !empty($product->thumbnail) )
                                      <img src="{{ asset($product->thumbnail) }}" alt="" style="width: 80px;">
                                    @endif
                                </td>
                                <td><strong>{{ $product->cat_name }}</strong></td>
                                <td><strong>{{ $product->subCat_name }}</strong></td>
                                <td><strong>{{ $product->brand_name }}</strong></td>
                                <td><strong>{{ $product->purchase_price }}</strong></td>
                                <td>
                                    <strong>
                                        @if ( !empty( $product->discount_price ) )
                                           {{ $product->discount_price }}
                                        @else
                                           {{ "N/A" }}
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    @if ( $product->status === 1 )
                                       <span class="badge bg-label-primary">Active</span>
                                    @else
                                          <span class="badge bg-label-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="actionList">
                                        <li>
                                            <a href="{{ route('product.edit', $product->id) }}">
                                                <i class='bx bx-edit-alt text-primary'></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product.delete', $product->id) }}">
                                                <i class='bx bx-trash text-danger'></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                   </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
   </div>

@endsection

@push('script')
    <script>
        let table = new DataTable('#productTable');
    </script>
@endpush

