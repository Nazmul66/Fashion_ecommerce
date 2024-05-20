@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - Category Page </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Category Manage</h5>
               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">Add Category</button>
           </div>

            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="categoryTable">
                  <thead>
                    <tr>
                      <th>#SL.</th>
                      <th>Category Name</th>
                      <th>Category Slug</th>
                      <th>Meta Title</th>
                      <th>Meta Description</th>
                      <th>Meta Keyword</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($categories as $row => $category)
                            <tr>
                                <td>{{ $row + 1 }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td><strong>{{ $category->slug }}</strong></td>
                                <td><strong>{{ $category->meta_title }}</strong></td>
                                <td><strong>{{ $category->meta_description }}</strong></td>
                                <td><strong>{{ $category->meta_keywords }}</strong></td>
                                <td>
                                    @if ( $category->status === 1 )
                                       <span class="badge bg-label-primary">Active</span>
                                    @else
                                          <span class="badge bg-label-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="actionList">
                                        <li>
                                            <span data-bs-toggle="modal" data-bs-target="#updateCategory{{ $category->id }}">
                                                <i class='bx bx-edit-alt text-primary'></i>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="{{ route('category.delete', $category->id) }}">
                                                <i class='bx bx-trash text-danger'></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>


                            {{-- Update Modal --}}
                            <div class="modal fade" id="updateCategory{{ $category->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalLabel3">Update Category</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    @php
                                        $category = App\Models\Category::where('id', $category->id)->first();
                                    @endphp

                                    <div class="modal-body">
                                       <form method="POST" action="{{ route('category.update', $category->id) }}">
                                            @csrf

                                            <div class="row">
                                                <div class="mb-3">
                                                <label for="cat_name" class="form-label">Category Name</label>
                                                    <input type="text" id="cat_name" name="cat_name" value="{{ $category->name }}" class="form-control" placeholder="Write Here.............">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ $category->meta_title }}" placeholder="Write Here.............">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_description" class="form-label">Meta Description</label>
                                                    <textarea class="form-control" id="meta_description" rows="4" name="meta_description">{{ $category->meta_description }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                                    <input type="text" id="meta_keyword" name="meta_keyword" value="{{ $category->meta_keywords }}" class="form-control" placeholder="Write Here.............">
                                                </div>


                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                    <option selected="" disabled="">Open this select menu</option>
                                                    <option value="1" @if( $category->status === 1 ) selected @endif>Active</option>
                                                    <option value="0" @if( $category->status === 0 ) selected @endif>InActive</option>
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
  <div class="modal fade" id="addCategory" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
           <form method="POST" action="{{ route('category.store') }}">
                @csrf

                <div class="row">
                    <div class="mb-3">
                       <label for="cat_name" class="form-label">Category Name</label>
                        <input type="text" id="cat_name" name="cat_name" class="form-control" placeholder="Write Here........">
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
        let table = new DataTable('#categoryTable');
    </script>
@endpush

