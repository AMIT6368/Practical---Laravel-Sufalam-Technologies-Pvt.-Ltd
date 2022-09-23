@extends('layouts.auth-master')
@section('content')
{{-- add new Vendor modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Vendor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
        @csrf
        
        <div class="modal-body p-4 bg-light">
           <div class="my-2">
            <label for="role">Select Role</label>
            <select class="form-control" name="role" id="role" required>
              <option value="">Select Role</option>
              @if($Roles->count()>0) @foreach($Roles as $Role)
              <option data="{{ucfirst($Role['id'])}}" value="{{ucfirst($Role['id'])}}">{{ucfirst($Role['name'])}}</option>
              @endforeach
              @endif
            </select>
          </div>
           <div class="my-2">
            <label for="fname_lname">Full Name</label>
            <input type="text" name="fname_lname" id="fname_lname" class="form-control" placeholder="Full Name" required>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="addemail" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="phone">Phone</label>
            <input type="tel" name="phone_number"  id="addphone"class="form-control" placeholder="Phone" required>
          </div>
          <div class="my-2">
            <label for="post">Address</label>
            <input type="text" name="post" class="form-control" placeholder="Post" required>
          </div>
           <div class="my-2">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" required>
              <option value="">Select Status</option>
              <option value="Active">Active</option>
              <option value="Deactive">Deactive</option>
              <option value="Block">Block</option>
            </select>
          </div>
          <div class="my-2">
            <label for="avatar">Select Profile Image</label>
            <input type="file" name="avatar" class="form-control" required>
          </div>
        </div>
        <span id="error_message" style="color:red;"></span>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Add Vendor</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new Vendor modal end --}}

{{-- edit Vendor modal start --}}
<div class="modal fade editEmployeeModal" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Vendor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="emp_avatar" id="emp_avatar">
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="role">Select Role</label>
            <select class="form-control" name="role" id="role_edit" required>
              @if($Roles->count()>0) @foreach($Roles as $Role)
              <option value="{{ucfirst($Role['id'])}}">{{ucfirst($Role['name'])}}</option>
              @endforeach
              @endif
            </select>
          </div>
          <div class="my-2">
            <label for="fname_lnameedit">Full Name</label>
            <input type="text" name="fname_lnameedit" id="fname_lnameedit" class="form-control" placeholder="Full Name" required>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone" required>
          </div>
          <div class="my-2">
            <label for="Address">Address</label>
            <input type="text" name="Address" id="Address" class="form-control" placeholder="Post" required>
          </div>
          <div class="my-2">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="statusEDIT" required>
              <option value="Active">Active</option>
              <option value="Deactive">Deactive</option>
              <option value="Block">Block</option>
            </select>
          </div>
          <div class="my-2">
            <label for="avatar">Select Avatar</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
          </div>
          <div class="mt-2" id="avatarfetch">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_employee_btn" class="btn btn-success">Update Vendor</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}

  <div class="bg-light">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Vendors</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                class="bi-plus-circle me-2"></i>Add New Vendor</button>
          </div>
          <div class="card-body" id="show_all_employees">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>

    $('body').on('keyup','#addemail',function(){
     var email= $('#addemail').val(); 
     if(email)
     {
       $('#error_message').html('');
       $("#add_employee_btn").text('Add Vendor');
     }
    });
      $('body').on('keyup','#addphone',function(){
     var phone= $('#addphone').val();
     if(phone)
     {
       $('#error_message').html('');
       $("#add_employee_btn").text('Add Vendor');
     }
    });

    $(function() {

      // add new employee ajax request
      $("#add_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_employee_btn").text('Adding...');
        $.ajax({
          url: '{{ url('store') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Vendor Added Successfully!',
                'success'
              )
              fetchAllEmployees();
              $('.modal-backdrop').css('position', 'inherit');
              $("#add_employee_btn").text('Add Employee');
              $("#add_employee_form")[0].reset();
              $("#addEmployeeModal").modal('hide');

              }else if (response.status == 201) {
                $("#error_message").html(response.errors);
                $("#add_employee_btn").text('Fixed Error First');

              }else{
             
              Swal.fire(
                'Oppps!',
                'Something went wromg',
                'danger'
              )
              fetchAllEmployees();
              $('.modal-backdrop').css('position', 'inherit');
              $("#add_employee_btn").text('Add Employee');
              $("#add_employee_form")[0].reset();
              $("#addEmployeeModal").modal('hide');

            }
            
          }
        });
      });

      // edit employee ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ url('edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#fname_lnameedit").val(response.name);
            $("#email").val(response.email);
            $("#phone").val(response.phone_number);
            $("#Address").val(response.address);
            $("#avatarfetch").html(
              `<img src="${response.profile_pic}" width="100" class="img-fluid img-thumbnail">`);
            $("#id ").val(response.id);
            $("#emp_avatar").val(response.profile_pic);
            $("#role_edit").val(response.role_id).attr('selected', true);
            $("#statusEDIT").val(response.status).attr('selected', true);
          }
        });
      });

      // update employee ajax request
      $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_employee_btn").text('Updating...');
        $.ajax({
          url: '{{ url('update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
                  Swal.fire(
                'Updated!',
                'Vendor Updated Successfully!',
                'success',
                 '1500'
              )
              fetchAllEmployees();
            }else{
             Swal.fire(
                'Opps!',
                'Something Went Wrong!',
                'error',
                 '1500'
              )
              fetchAllEmployees();
            }
            $("#edit_employee_btn").text('Update Employee');
            $('.modal-backdrop').css('position', 'inherit');
            $(".editEmployeeModal").modal('hide');
          }
        });
      });

      // delete employee ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ url('delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllEmployees();
              }
            });
          }
        })
      });

      // fetch all employees ajax request
      fetchAllEmployees();

      function fetchAllEmployees() {
        $.ajax({
          url: '{{url('fetchAll')}}',
          method: 'get',
          headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
          success: function(response) {
            $("#show_all_employees").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });
  </script>
@endsection
