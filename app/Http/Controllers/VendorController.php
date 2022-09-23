<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Role;
use Illuminate\Http\Request;
use Validator;
use DB;
use Session;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function index() {
        $Roles = Role::all();
        return view('vendor.vendor')->with(['Roles'=>$Roles]);
    }

    // handle fetch all Vendor ajax request
    public function fetchAll() {
        $vendors = DB::table('vendors')->select(array('vendors.*', 'roles.name as role_name'))->join('roles', 'roles.id', '=', 'vendors.role_id')->get();
        $output = '';
        if ($vendors->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Detail</th>
                <th>Role</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($vendors as $vendor) {
                $role = Role::find($vendor->role_id);
                $output .= '<tr>
                <td>' . $vendor->id . '</td>
                <td><img src="'.$vendor->profile_pic.'" width="50" class="img-thumbnail rounded-circle"></td>
                <td>
                  <strong>Full Name:</strong>' . $vendor->name . ' <br>
                  <strong>Email:</strong>' . $vendor->email . ' <br>
                  <strong>Mobile:</strong>' . $vendor->phone_number . ' <br>
                </td>

                <td>' . $vendor->role_name. '</td>
                <td>' . $vendor->address . '</td>
                <td>' . $vendor->status . '</td>
                <td>
                  <a style="color: white !important;" href="#" id="' . $vendor->id . '" class="text-success mx-1 editIcon btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i>Edit</a>

                  <a style="color: white !important;" href="#" id="' . $vendor->id . '" class="text-danger mx-1 deleteIcon btn btn-danger me-2"><i class="bi-trash h4"></i>Delete</a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    // handle insert a new Vendor ajax request
    public function store(Request $request) {

        $rules = array(
        'email'     =>  'required|max:50|unique:vendors,email',
        'phone_number'     =>  'required|max:10|min:10|unique:vendors',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
          return response()->json(['errors' => $error->errors()->all(),'status' => 201]);
        }

        $file = $request->file('avatar');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('storage/images/', $fileName);
        $file->move('storage/images/', $fileName);
        $imageurl=url('/storage/images/'.$fileName);
        $empData = ['role_id' => $request->role, 'name' => $request->fname_lname, 'email' => $request->email, 'phone_number' => $request->phone_number, 'address' => $request->post, 'profile_pic' => $imageurl, 'status' => $request->status, 'crated_at'=> time()];
        Vendor::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle edit an Vendor ajax request
    public function edit(Request $request) {
        $id = $request->id;
        $emp = Vendor::find($id);
        return response()->json($emp);
    }

    // handle update an Vendor ajax request
    public function update(Request $request) {
        $fileName = '';
        $emp = Vendor::find($request->id);
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
             $file->storeAs('storage/images/', $fileName);
             $file->move('storage/images/', $fileName);
             $imageurl=url('/storage/images/'.$fileName);
            // $file->storeAs('storage/images', $fileName);
            // if ($emp->profile_pic) {
            //     Storage::delete('public/images/' . $emp->avatar);
            // }
        } else {
            $imageurl = $emp->profile_pic;
            $imageurl = $emp->profile_pic;
        }

        $empData = ['role_id' => $request->role, 'name' => $request->fname_lnameedit, 'email' => $request->email, 'phone_number' => $request->phone, 'address' => $request->Address, 'profile_pic' => $imageurl, 'status' => $request->status, 'updated_at' => time()];

        $emp->update($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an Vendor ajax request
    public function delete(Request $request) {
        $id = $request->id;
        $emp = Vendor::find($id);
         Vendor::destroy($id);
        if (Storage::delete('public/images/' . $emp->avatar)) {
        }
    }
}
