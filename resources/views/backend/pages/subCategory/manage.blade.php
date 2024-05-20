@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - SubCategory Page </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">SubCategory Manage</h5>
               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubCategory">Add SubCategory</button>
           </div>

            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="subCategoryTable">
                  <thead>
                    <tr>
                      <th>#SL.</th>
                      {{-- <th>#SL.</th> --}}
                      <th>SubCategory Name</th>
                      <th>SubCategory Slug</th>
                      <th>Meta Title</th>
                      <th>Meta Description</th>
                      <th>Meta Keyword</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($subCategories as $row => $subCategory)
                            <tr>
                                <td>{{ $row + 1 }}</td>
                                <td><strong>{{ $subCategory->name }}</strong></td>
                                <td><strong>{{ $subCategory->slug }}</strong></td>
                                <td><strong>{{ $subCategory->meta_title }}</strong></td>
                                <td><strong>{{ $subCategory->meta_description }}</strong></td>
                                <td><strong>{{ $subCategory->meta_keywords }}</strong></td>
                                <td>
                                    @if ( $subCategory->status === 1 )
                                       <span class="badge bg-label-primary">Active</span>
                                    @else
                                          <span class="badge bg-label-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="actionList">
                                        <li>
                                            <span data-bs-toggle="modal" data-bs-target="#updateSubCategory{{ $subCategory->id }}">
                                                <i class='bx bx-edit-alt text-primary'></i>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="{{ route('subCategory.delete', $subCategory->id) }}">
                                                <i class='bx bx-trash text-danger'></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>


                            {{-- Update Modal --}}
                            <div class="modal fade" id="updateSubCategory{{ $subCategory->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalLabel3">Update SubCategory</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    @php
                                        $category = App\Models\SubCategory::where('id', $subCategory->id)->first();
                                    @endphp

                                    <div class="modal-body">
                                       <form method="POST" action="{{ route('subCategory.update', $subCategory->id) }}">
                                            @csrf

                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="cat_id" class="form-label">Category Name</label>
                                                    <select class="form-select" id="cat_id" name="cat_id">
                                                       <option selected="" disabled="">Open this select menu</option>
                                                        @foreach ($categories as $category)
                                                           <option value="{{ $category->id }}" @if( $category->id === $subCategory->category_id ) selected @endif>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="cat_name" class="form-label">SubCategory Name</label>
                                                    <input type="text" id="cat_name" name="subCat_name" value="{{ $subCategory->name }}" class="form-control" placeholder="Write Here.............">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ $subCategory->meta_title }}" placeholder="Write Here.............">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_description" class="form-label">Meta Description</label>
                                                    <textarea class="form-control" id="meta_description" rows="4" name="meta_description">{{ $subCategory->meta_description }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                                    <input type="text" id="meta_keyword" name="meta_keyword" value="{{ $subCategory->meta_keywords }}" class="form-control" placeholder="Write Here.............">
                                                </div>


                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                    <option selected="" disabled="">Open this select menu</option>
                                                    <option value="1" @if( $subCategory->status === 1 ) selected @endif>Active</option>
                                                    <option value="0" @if( $subCategory->status === 0 ) selected @endif>InActive</option>
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
    <div class="modal fade" id="addSubCategory" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel3">Add SubCategory</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            <form method="POST" action="{{ route('subCategory.store') }}">
                    @csrf

                    <div class="row">
                        <div class="mb-3">
                            <label for="cat_id" class="form-label">Category Name</label>
                            <select class="form-select" id="cat_id" name="cat_id">
                            <option selected="" disabled="">Open this select menu</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                        <label for="subCat_name" class="form-label">SubCategory Name</label>
                            <input type="text" id="subCat_name" name="subCat_name" class="form-control" placeholder="Write Here........">
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
        let table = new DataTable('#subCategoryTable');
    </script>
@endpush

