@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - Color Page </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Color Manage</h5>
               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addColor">Add Color</button>
           </div>

            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="colorTable">
                  <thead>
                    <tr>
                      <th>#SL.</th>
                      <th>Color Name</th>
                      <th>Color Code</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($colors as $row => $color)
                            <tr>
                                <td>{{ $row + 1 }}</td>
                                <td><strong>{{ ucfirst($color->name) }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="color_div me-3" style="background: {{ $color->code }}"></span>
                                        <strong><span class="badge bg-label-dark">{{ $color->code }}</span></strong>
                                    </div>
                                </td>
                                <td>
                                    @if ( $color->status === 1 )
                                       <span class="badge bg-label-primary">Active</span>
                                    @else
                                          <span class="badge bg-label-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="actionList">
                                        <li>
                                            <span data-bs-toggle="modal" data-bs-target="#updateColor">
                                                <i class='bx bx-edit-alt text-primary'></i>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="{{ route('color.delete', $color->id) }}">
                                                <i class='bx bx-trash text-danger'></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>


                            {{-- Update Modal --}}
                            <div class="modal fade" id="updateColor" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalLabel3">Update Color</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    @php
                                        $color = App\Models\Color::where('id', $color->id)->first();
                                    @endphp

                                    <div class="modal-body">
                                       <form method="POST" action="{{ route('color.update', $color->id) }}">
                                            @csrf

                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="color_name" class="form-label">Color Name</label>
                                                    <input type="text" id="color_name" name="color_name" value="{{ $color->name }}" class="form-control" placeholder="Write Here........">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="color_code" class="form-label">Color Code</label>
                                                    <input type="color" class="form-control" value="{{ $color->code }}" id="color_code" name="color_code">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                    <option selected="" disabled="">Open this select menu</option>
                                                    <option value="1" @if( $color->status === 1 ) selected @endif>Active</option>
                                                    <option value="0" @if( $color->status === 0 ) selected @endif>InActive</option>
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
  <div class="modal fade" id="addColor" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Add Color</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
           <form method="POST" action="{{ route('color.store') }}">
                @csrf

                <div class="row">
                    <div class="mb-3">
                       <label for="color_name" class="form-label">Color Name</label>
                        <input type="text" id="color_name" name="color_name" class="form-control" placeholder="Write Here........">
                    </div>

                    <div class="mb-3">
                        <label for="color_code" class="form-label">Color Code</label>
                        <input type="color" class="form-control" value="#666EE8" id="color_code" name="color_code">
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
        let table = new DataTable('#colorTable');
    </script>
@endpush

