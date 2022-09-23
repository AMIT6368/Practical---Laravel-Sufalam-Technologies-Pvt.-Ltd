@extends('layouts.auth-master')
@section('content')
{{-- add new Role modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
           <div class="my-2">
            <label for="name">Role Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Role Name" required>
            <span id="error_message" style="color:red;"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Add Role</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new Role modal end --}}

{{-- edit Role modal start --}}
<div class="modal fade editEmployeeModal" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
        <input type="hidden" name="id" id="id_edit">
        
          <div class="my-2">
            <label for="name_edit">Role Name</label>
            <input type="text" name="name" id="name_edit" class="form-control" placeholder="Role Name" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_employee_btn" class="btn btn-success">Update Role</button>
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
            <h3 class="text-light">Manage Role</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                class="bi-plus-circle me-2"></i>Add New Role</button>
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

    $('body').on('keyup','#name',function(){
     var name= $('#name').val();
     if(name)
     {
       $('#error_message').html('');
       $("#add_employee_btn").text('Add Role');
     }
    });


    $(function() {

      // add new employee ajax request
      $("#add_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_employee_btn").text('Adding...');
        $.ajax({
          url: '{{ url('storeRole') }}',
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
                'Role Added Successfully!',
                'success'
              )
              fetchAllEmployees();
              $('.modal-backdrop').css('position', 'inherit');
              $("#add_employee_btn").text('Add Role');
              $("#add_employee_form")[0].reset();
              $("#addEmployeeModal").modal('hide');
            }else if (response.status == 201) {
                $("#error_message").html(response.errors);
                $("#add_employee_btn").text('Change Name');
            }else{
             
              Swal.fire(
                'Oppps!',
                'Something went wromg',
                'danger'
              )
              fetchAllEmployees();
              $('.modal-backdrop').css('position', 'inherit');
              $("#add_employee_btn").text('Add Role');
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
          url: '{{ url('editRole') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#name_edit").val(response.name);
            $("#id_edit").val(response.id);
          }
        });
      });

      // update employee ajax request
      $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_employee_btn").text('Updating...');
        $.ajax({
          url: '{{ url('updateRole') }}',
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
                'Role Updated Successfully!',
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
            $("#edit_employee_btn").text('Update Role');
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
              url: '{{ url('deleteRole') }}',
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
          url: '{{url('fetchAllRole')}}',
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
