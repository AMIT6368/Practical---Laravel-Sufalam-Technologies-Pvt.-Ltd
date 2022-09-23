<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;

class RoleController extends Controller
{
    public function index() {
        $Roles = Role::all();
        return view('role.role');
    }


    // handle fetch all Role ajax request
    public function fetchAllRole() {
        $Roles = Role::all();
        $output = '';
        if ($Roles->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($Roles as $Role) {
                $output .= '<tr>
                <td>' . $Role->id . '</td>
                
                <td>' . $Role->name . '</td>
                <td>
                  <a style="color: white !important;" href="#" id="' . $Role->id . '" class="text-success mx-1 editIcon btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i>Edit</a>

                  <a style="color: white !important;" href="#" id="' . $Role->id . '" class="text-danger mx-1 deleteIcon btn btn-danger me-2"><i class="bi-trash h4"></i>Delete</a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    // handle insert a new Role ajax request
    public function storeRole(Request $request) {

    $rules = array(
    'name'     =>  'required|max:50|unique:roles',
    );
    $error = Validator::make($request->all(), $rules);
    if($error->fails())
    {
      return response()->json(['errors' => $error->errors()->all(),'status' => 201]);
    }
        
    $empData = ['name' => $request->name];
    Role::create($empData);
    return response()->json([
        'status' => 200,
    ]);
    }

    // handle edit an Role ajax request
    public function editRole(Request $request) {
        $id = $request->id;
        $emp = Role::find($id);
        return response()->json($emp);
    }

    // handle update an Role ajax request
    public function updateRole(Request $request) {
        $fileName = '';
        $emp = Role::find($request->id);
        $empData = ['name' => $request->name];

        $emp->update($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an Role ajax request
    public function deleteRole(Request $request) {
        $id = $request->id;
        $emp = Role::find($id);
         Role::destroy($id);
    }
}
