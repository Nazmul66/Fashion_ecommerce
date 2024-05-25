@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - Shipping Charge Page </title>
@endpush

@section('body-content')

<div class="row">
    <div class="col-lg-12">
      <div class="card">
         <div class="d-flex justify-content-between align-items-center">
             <h5 class="card-header">Shipping Charge Manage</h5>
             <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShippingCharge">Add Shipping Charge</button>
         </div>

          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table table-bordered" id="shippingTable">
                <thead>
                  <tr>
                    <th>#SL.</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>
                      @foreach ($shippingCharges as $row => $shippingCharge)
                          <tr>
                              <td>{{ $row + 1 }}</td>
                              <td><strong>{{ $shippingCharge->name }}</strong></td>
                              <td><strong>{{ $shippingCharge->price }}</strong></td>
                              <td>
                                  @if ( $shippingCharge->status === 1 )
                                     <span class="badge bg-label-primary">Active</span>
                                  @else
                                        <span class="badge bg-label-danger">InActive</span>
                                  @endif
                              </td>
                              <td>
                                  <ul class="actionList">
                                      <li>
                                          <span data-bs-toggle="modal" data-bs-target="#updateShippingCharge{{ $shippingCharge->id }}">
                                              <i class='bx bx-edit-alt text-primary'></i>
                                          </span>
                                      </li>
                                      <li>
                                          <a href="{{ route('shipping.delete', $shippingCharge->id) }}">
                                              <i class='bx bx-trash text-danger'></i>
                                          </a>
                                      </li>
                                  </ul>
                              </td>
                          </tr>


                          {{-- Update Modal --}}
                          <div class="modal fade" id="updateShippingCharge{{ $shippingCharge->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                     <h5 class="modal-title" id="exampleModalLabel3">Update Shipping Charge</h5>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>

                                  @php
                                      $shippingCharge = App\Models\ShippingCharge::where('id', $shippingCharge->id)->first();
                                  @endphp

                                  <div class="modal-body">
                                     <form method="POST" action="{{ route('shipping.update', $shippingCharge->id) }}">
                                          @csrf

                                          <div class="row">
                                              <div class="mb-3">
                                                 <label for="name" class="form-label">Shipping Name</label>
                                                  <input type="text" id="name" name="name" value="{{ $shippingCharge->name }}" class="form-control">
                                              </div>

                                              <div class="mb-3">
                                                <label for="price" class="form-label">Shipping Name</label>
                                                 <input type="number" id="price" name="price" value="{{ $shippingCharge->price }}" class="form-control">
                                             </div>


                                              <div class="mb-3">
                                                  <label for="status" class="form-label">Status</label>
                                                  <select class="form-select" id="status" name="status">
                                                       <option selected="" disabled="">Open this select menu</option>
                                                       <option value="1" @if( $shippingCharge->status === 1 ) selected @endif>Active</option>
                                                       <option value="0" @if( $shippingCharge->status === 0 ) selected @endif>InActive</option>
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
<div class="modal fade" id="addShippingCharge" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3">Add Shipping Charge</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
         <form method="POST" action="{{ route('shipping.store') }}">
              @csrf

              <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Shipping Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Shipping Price</label>
                        <input type="number" id="price" name="price" class="form-control">
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
        let table = new DataTable('#shippingTable');
    </script>
@endpush