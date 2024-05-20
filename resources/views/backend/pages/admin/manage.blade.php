@extends('backend.layout.template')

@push('meta-title')
    <title>Dashboard - E-commerce </title>
@endpush

@section('body-content')

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
           <div class="d-flex justify-content-between align-items-center">
               <h5 class="card-header">Bordered Table</h5>
               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdmin">Add New Admin</button>
           </div>

            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#SL.</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody id="ytable">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
   </div>


  {{-- Update Modal --}}
  <div class="modal fade" id="updateAdmin" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Update New Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
           <form action="">
                <div class="row">

                    <input type="hidden" id="up_id" name="up_id">

                    <div class="mb-3">
                       <label for="Name" class="form-label">Name</label>
                        <input type="text" id="up_name" class="form-control" placeholder="Enter Name">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="up_email" class="form-control" disabled placeholder="Enter Email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="up_password" class="form-control" placeholder="****************************">
                    </div>

                    <div class="mb-3">
                      <label for="role" class="form-label">Role</label>
                      <select class="form-select" id="update_role">
                         <option selected="" disabled="">Open this select menu</option>
                         <option value="1">Admin</option>
                         <option value="2">User</option>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="update_status" class="form-label">Status</label>
                      <select class="form-select" id="update_status">
                         <option selected="" disabled="">Open this select status</option>
                         <option value="1">Active</option>
                         <option value="0">InActive</option>
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


  {{-- Add Modal --}}
  <div class="modal fade" id="addAdmin" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Add New Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
           <form action="" id="adminForm">
                <div class="row">
                    <div class="mb-3">
                       <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Enter Name">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter Email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter Password">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                           <option selected="" disabled="">Open this select menu</option>
                           <option value="1">Admin</option>
                           <option value="2">User</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_store">Save changes</button>
                </div>
           </form>
        </div>
      </div>
    </div>
  </div>

@endsection


@push('script')
    <script>
       $(document).ready(function(){
         // store data
          $('#btn_store').click(function(e){
              e.preventDefault();

              var name       = $('#name').val();
              var email      = $('#email').val();
              var password   = $('#password').val();
              var role       = $('#role').val();

              const obj = { name, email, password, role };
              console.log(obj);

              $.ajax({
                  method:"POST",
                  url: "{{ route('admin.store') }}",
                  data: obj,
                  success: function(data){
                     console.log(data);
                     if( data.status == 'success' ){
                         $('#adminForm')[0].reset();
                         $('#addAdmin').modal('hide');
                         getData();
                     }
                  },
                  error: function(err){
                     console.log(err);
                  }
              });
          })

          // get data
          function getData(){
            $.ajax({
                  method:"GET",
                  url: "{{ route('admin.getData') }}",
                  success: function(data){
                    //  console.log(data);
                    let users = data.allUser;

                 $('#ytable').empty();
                 if( users.length > 0 ){
                    for( let i=0; i<users.length; i++ ){
                        $('#ytable').append(`
                        <tr>
                            <td>`+ (i+1) +`</td>
                            <td>
                                <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>`+ users[i]['name'] +`</strong>
                            </td>
                            <td>
                                <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>`+ users[i]['email'] +`</strong>
                            </td>
                            <td>
                                 <span class="badge `+ ( users[i]['role'] == 1 ? 'bg-primary' : users[i]['role'] == 2 ? 'bg-success' : 'bg-info') +`">`+ ( users[i]['role'] == 1 ? 'Admin' : users[i]['role'] == 2 ? 'Customer' : 'Super Admin') +`</span>
                            </td>
                            <td><span class="badge `+ ( users[i]['status'] == 1 ? 'bg-label-primary' : "bg-label-danger" ) +` me-1">`+ ( users[i]['status'] === 1 ? 'active' : "inactive" ) +`</span></td>
                            <td>
                                <ul class="action_list">
                                    `+
                                        (users[i]['role'] !== 3 ? `
                                        <li class="me-2">
                                            <button
                                                type="button"
                                                style="cursor: pointer; border: none;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#updateAdmin"
                                                value="`+ users[i]['id'] +`"
                                                class="text-info"
                                            >
                                                <i class='bx bx-edit-alt'></i>
                                            </button>
                                        </li>
                                        <li>
                                            <button
                                                type="button"
                                                style="cursor: pointer; border: none;"
                                                class="text-danger"
                                                value="`+ users[i]['id'] +`"
                                            >
                                                <i class='bx bx-trash text-danger'></i>
                                            </button>
                                        </li>
                                        ` : '')
                                        +`
                                </ul>
                            </td>
                        </tr>`);
                        }
                    }
                    else{
                        $('#ytable').append(
                            `<tr>
                                <td colspan="6">NO Data Found</td>
                            </tr>
                            `
                        );
                    }
                  },
                error: function(err){
                    console.log(err);
                }
            });
          }

          // initially load data
          getData();

          // Set data
          $(document).on("click",".text-info",function(e){
              e.preventDefault();
              var id = $(this).val();
              // alert(id);

              $.ajax({
                  method: 'POST',
                  url: '{{ route("admin.editData") }}',
                  data: {id: id},
                  success: function(data){
                    //  console.log(data.user);
                    let user = data.user;

                     console.log(user.id);

                    $('#up_id').val(user.id);
                    $('#up_name').val(user.name);
                    $('#up_email').val(user.email);
                    $('#update_role').val(user.role);
                    $('#update_status').val(user.status);
                  },
                  error: function(err){
                     console.log(err);
                  }
             });

          })


          // update data
          $('#btn_update').click(function(e){
              e.preventDefault();

              var id         = $('#up_id').val();
              var name       = $('#up_name').val();
              var password   = $('#up_password').val();
              var role       = $('#update_role').val();
              var status     = $('#update_status').val();

              const obj = { id, name, password, role, status };
              console.log('data send to',obj);

              $.ajax({
                  method:"POST",
                  url: "{{ route('admin.updateData') }}",
                  data: obj,
                  success: function(data){
                     console.log("server side data",data);
                     if( data.status == 'success' ){
                         $('#updateAdmin').modal('hide');
                         getData();
                     }
                  },
                  error: function(err){
                     console.log(err);
                  }
              });
          })

           // update data
           $(document).on("click",".text-danger",function(e){
                e.preventDefault();

                e.preventDefault();
                 var id = $(this).val();

                $.ajax({
                  method:"post",
                  url: "{{ route('admin.deleteData') }}",
                  data: { id: id },
                  success: function(data){
                      if( data.status === "success" ){
                           getData();
                      }
                  },
                  error:function(err){
                       console.log(err)
                  },
                })
           });

});
    </script>
@endpush
