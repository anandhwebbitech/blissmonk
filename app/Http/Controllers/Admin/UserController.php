<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::where('user_type', 'user')->latest();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('status', function ($row) {

                    return $row->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('verified', function ($row) {

                    return $row->email_verified_at
                        ? '<span class="badge bg-success">Verified</span>'
                        : '<span class="badge bg-warning">Pending</span>';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <a href="'.route('admin.users.edit',$row->id).'"
                           class="btn btn-sm btn-primary">
                           Edit
                        </a>

                        <button class="btn btn-sm btn-danger delete"
                            data-route="'.route('admin.users.destroy',$row->id).'">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns(['status','verified','action'])

                ->make(true);
        }

        return view('admin.users.index');
    }

   

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

   

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required',
            'state' => 'nullable',
            'city' => 'nullable',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'status' => $request->status
        ];

       
        if ($request->password) {

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                ->with('success', 'User Updated Successfully');
    }

  

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ]);
    }
}