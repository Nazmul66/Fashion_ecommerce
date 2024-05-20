@extends('backend.layout.template')

@push('meta-title')
    <title>Ecommerce - feature page</title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Feature Manage</h5>
               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeature">Add Feature</button>
           </div>

            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered" id="feature_Table">
                  <thead>
                    <tr>
                      <th>#SL.</th>
                      <th>Feature Name</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($features as $row => $feature)
                            <tr>
                                <td>{{ $row + 1 }}</td>
                                <td><strong>{{ ucfirst($feature->feature_name) }}</strong></td>
                                <td>
                                    @if ( $feature->status === 1 )
                                       <span class="badge bg-label-primary">Active</span>
                                    @else
                                          <span class="badge bg-label-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="actionList">
                                        <li>
                                            <span data-bs-toggle="modal" data-bs-target="#updateFeature">
                                                <i class='bx bx-edit-alt text-primary'></i>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="{{ route('feature.delete', $feature->id) }}">
                                                <i class='bx bx-trash text-danger'></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>


                            {{-- Update Modal --}}
                            <div class="modal fade" id="updateFeature" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalLabel3">Update Feature</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    @php
                                        $feature = App\Models\Feature::where('id', $feature->id)->first();
                                    @endphp

                                    <div class="modal-body">
                                       <form method="POST" action="{{ route('feature.update', $feature->id) }}">
                                            @csrf

                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="feature_name" class="form-label">Color Name</label>
                                                    <input type="text" id="feature_name" name="feature_name" value="{{ $feature->feature_name }}" class="form-control" placeholder="Write Here........">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                    <option selected="" disabled="">Open this select menu</option>
                                                    <option value="1" @if( $feature->status === 1 ) selected @endif>Active</option>
                                                    <option value="0" @if( $feature->status === 0 ) selected @endif>InActive</option>
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
  <div class="modal fade" id="addFeature" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Add Color</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
           <form method="POST" action="{{ route('feature.store') }}">
                @csrf

                <div class="row">
                    <div class="mb-3">
                       <label for="feature_name" class="form-label">Feature Name</label>
                        <input type="text" id="feature_name" name="feature_name" class="form-control" placeholder="Write Here........">
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
        let table = new DataTable('#feature_Table');
    </script>
@endpush

