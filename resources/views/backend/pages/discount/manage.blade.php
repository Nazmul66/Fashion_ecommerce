@extends('backend.layout.template')

@push('meta-title')
    <title>E-commerce - discount Page </title>
@endpush

@section('body-content')

<div class="row">
    <div class="col-lg-12">
      <div class="card">
         <div class="d-flex justify-content-between align-items-center">
             <h5 class="card-header">Discount Manage</h5>
             <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDiscount">Add Discount</button>
         </div>

          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table table-bordered" id="discountTable">
                <thead>
                  <tr>
                    <th>#SL.</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Percent Amount</th>
                    <th>Expire Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>
                      @foreach ($discounts as $row => $discount)
                          <tr>
                              <td>{{ $row + 1 }}</td>
                              <td><strong>{{ $discount->name }}</strong></td>
                              <td><strong>{{ $discount->type }}</strong></td>
                              <td>
                                <strong>
                                    @if ( $discount->type === "amount" )
                                        {{ $discount->percent_amount }}TK
                                    @else
                                        {{ $discount->percent_amount }}%
                                    @endif
                                 </strong>
                               </td>
                              <td><strong>{{ $discount->expire_date }}</strong></td>
                              <td>
                                  @if ( $discount->status === 1 )
                                     <span class="badge bg-label-primary">Active</span>
                                  @else
                                        <span class="badge bg-label-danger">InActive</span>
                                  @endif
                              </td>
                              <td>
                                  <ul class="actionList">
                                      <li>
                                          <span data-bs-toggle="modal" data-bs-target="#updateDiscount{{ $discount->id }}">
                                              <i class='bx bx-edit-alt text-primary'></i>
                                          </span>
                                      </li>
                                      <li>
                                          <a href="{{ route('discount.delete', $discount->id) }}">
                                              <i class='bx bx-trash text-danger'></i>
                                          </a>
                                      </li>
                                  </ul>
                              </td>
                          </tr>


                          {{-- Update Modal --}}
                          <div class="modal fade" id="updateDiscount{{ $discount->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                     <h5 class="modal-title" id="exampleModalLabel3">Update Discount</h5>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>

                                  @php
                                      $discount = App\Models\Discount::where('id', $discount->id)->first();
                                  @endphp

                                  <div class="modal-body">
                                     <form method="POST" action="{{ route('discount.update', $discount->id) }}">
                                          @csrf

                                          <div class="row">
                                              <div class="mb-3">
                                                 <label for="name" class="form-label">Discount Name</label>
                                                  <input type="text" id="name" name="name" value="{{ $discount->name }}" class="form-control">
                                              </div>

                                              <div class="mb-3">
                                                  <label for="type" class="form-label">Type</label>

                                                  <select class="form-select" id="type" name="type">
                                                    <option selected="">Open this select menu</option>
                                                    <option value="amount" @if( $discount->type === 'amount' ) selected @endif>Amount</option>
                                                    <option value="percent" @if( $discount->type === 'percent' ) selected @endif>Percent</option>
                                                </select>
                                              </div>

                                              <div class="mb-3">
                                                  <label for="percent_amount" class="form-label">Percent / Amount</label>
                                                  <input type="number" id="percent_amount" name="percent_amount" value="{{ $discount->percent_amount }}" class="form-control">
                                              </div>

                                              <div class="mb-3">
                                                <label for="expire_date" class="form-label">Expire Date</label>
                                                <input type="date" class="form-control" id="expire_date" value="{{ $discount->expire_date }}" name="expire_date">
                                             </div> 

                                              <div class="mb-3">
                                                  <label for="status" class="form-label">Status</label>
                                                  <select class="form-select" id="status" name="status">
                                                       <option selected="" disabled="">Open this select menu</option>
                                                       <option value="1" @if( $discount->status === 1 ) selected @endif>Active</option>
                                                       <option value="0" @if( $discount->status === 0 ) selected @endif>InActive</option>
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
<div class="modal fade" id="addDiscount" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3">Add Discount</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
         <form method="POST" action="{{ route('discount.store') }}">
              @csrf

              <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Discount Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" aria-label="Default select example">
                            <option selected="">Open this select menu</option>
                            <option value="amount">Amount</option>
                            <option value="percent">Percent</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="percent_amount" class="form-label">Percent / Amount</label>
                        <input type="number" id="percent_amount" name="percent_amount" class="form-control">
                    </div>

                    <div class="mb-3">
                       <label for="expire_date" class="form-label">Expire Date</label>
                       <input type="date" class="form-control" id="expire_date" name="expire_date">
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
        let table = new DataTable('#discountTable');
    </script>
@endpush