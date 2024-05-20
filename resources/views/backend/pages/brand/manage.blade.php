@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - Brand Page </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Brand Manage</h5>
               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrand">Add Brand</button>
           </div>

            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="brandTable">
                  <thead>
                    <tr>
                      <th>#SL.</th>
                      <th>Brand Name</th>
                      <th>Brand Slug</th>
                      <th>Meta Title</th>
                      <th>Meta Description</th>
                      <th>Meta Keyword</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($brands as $row => $brand)
                            <tr>
                                <td>{{ $row + 1 }}</td>
                                <td><strong>{{ $brand->name }}</strong></td>
                                <td><strong>{{ $brand->slug }}</strong></td>
                                <td><strong>{{ $brand->meta_title }}</strong></td>
                                <td><strong>{{ $brand->meta_description }}</strong></td>
                                <td><strong>{{ $brand->meta_keywords }}</strong></td>
                                <td>
                                    @if ( $brand->status === 1 )
                                       <span class="badge bg-label-primary">Active</span>
                                    @else
                                          <span class="badge bg-label-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="actionList">
                                        <li>
                                            <span data-bs-toggle="modal" data-bs-target="#updateBrand{{ $brand->id }}">
                                                <i class='bx bx-edit-alt text-primary'></i>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="{{ route('brand.delete', $brand->id) }}">
                                                <i class='bx bx-trash text-danger'></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>


                            {{-- Update Modal --}}
                            <div class="modal fade" id="updateBrand{{ $brand->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalLabel3">Update Brand</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    @php
                                        $brand = App\Models\Brand::where('id', $brand->id)->first();
                                    @endphp

                                    <div class="modal-body">
                                       <form method="POST" action="{{ route('brand.update', $brand->id) }}">
                                            @csrf

                                            <div class="row">
                                                <div class="mb-3">
                                                <label for="brand_name" class="form-label">Brand Name</label>
                                                    <input type="text" id="brand_name" name="brand_name" value="{{ $brand->name }}" class="form-control" placeholder="Write Here.............">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ $brand->meta_title }}" placeholder="Write Here.............">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_description" class="form-label">Meta Description</label>
                                                    <textarea class="form-control" id="meta_description" rows="4" name="meta_description">{{ $brand->meta_description }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                                    <input type="text" id="meta_keyword" name="meta_keyword" value="{{ $brand->meta_keywords }}" class="form-control" placeholder="Write Here.............">
                                                </div>


                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                       <option selected="" disabled="">Open this select menu</option>
                                                       <option value="1" @if( $brand->status === 1 ) selected @endif>Active</option>
                                                       <option value="0" @if( $brand->status === 0 ) selected @endif>InActive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" id="btn_update">Save changes</button>
                                            </div>
                                        </form>
                                     </div>
                                  </div>
                                </div>
                            </div>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
       </div>
   </div>


  {{-- Add Modal --}}
  <div class="modal fade" id="addBrand" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Add Brand</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
           <form method="POST" action="{{ route('brand.store') }}">
                @csrf

                <div class="row">
                    <div class="mb-3">
                       <label for="brand_name" class="form-label">Brand Name</label>
                        <input type="text" id="brand_name" name="brand_name" class="form-control" placeholder="Write Here........">
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Write Here........">
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" rows="4" name="meta_description" placeholder="Write Here........"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="meta_keyword" class="form-label">Meta Keyword</label>
                        <input type="text" id="meta_keyword" name="meta_keyword" class="form-control" placeholder="Write Here........">
                    </div>


                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                           <option selected="" disabled="">Open this select menu</option>
                           <option value="1">Active</option>
                           <option value="0">InActive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_store">Submit</button>
                </div>
           </form>
        </div>
      </div>
    </div>
  </div>

@endsection


@push('script')
    <script>
        let table = new DataTable('#brandTable');
    </script>
@endpush

