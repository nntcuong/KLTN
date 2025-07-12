<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminManagementDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminManagementController extends Controller
{
  
    public function index(AdminManagementDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.admin-management.index');
    }

    public function create() : View
    {
        return view('admin.admin-management.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:admin'],
            'password' => ['required', 'confirmed', 'min:5']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        toastr()->success('Created Successfully');

        return to_route('admin.admin-management.index');
    }

   
    public function edit(string $id) : View
    {
        $admin = User::findOrFail($id);
        return view('admin.admin-management.edit', compact('admin'));
    }

  
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if($id == 1){
            throw ValidationException::withMessages(['you can not update super admin']);
        }

        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$id],
            'role' => ['required', 'in:admin'],
        ]);

        if($request->has('password') && $request->filled('password')){
            $request->validate([
                'password' => ['confirmed', 'min:5']
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        toastr()->success('Created Successfully');

        return to_route('admin.admin-management.index');
    }

    public function destroy(string $id)
    {
        if($id == 1){
            throw ValidationException::withMessages(['you can not delete super admin']);
        }
        try {
            $admin = User::findOrFail($id);
            $admin->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
