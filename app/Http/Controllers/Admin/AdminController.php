<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $administrator = Admin::all();
        return view('admin.role-permission.administrator.index', [
            'administrators' => $administrator
        ]);
    }

    public function create()
    {
        $roles = Role::get();
        return view('admin.role-permission.administrator.create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $administrator = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $administrator->syncRoles($request->roles);

        return redirect(route('admin.administrator.index'))->with('status', 'Administator created successfully with roles.');
    }

    public function edit($id)
    {
        $administrator = Admin::findOrFail($id);
        $roles = Role::all();
        $adminRoles = $administrator->roles->pluck('name', 'name')->all();
        return view('admin.role-permission.administrator.edit', [
            'administrator' => $administrator,
            'roles' => $roles,
            'adminRoles' => $adminRoles
        ]);
    }

    public function update(Request $request, Admin $administrator)
    {
        $validation = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $administrator->id,
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ];

        $request->validate($validation);

        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];
        if (!empty(trim($request->password))) {
            $data['password'] = Hash::make($request->password);
        }

        $administrator->update($data);
        $administrator->syncRoles($request->roles);

        return redirect(route('admin.administrator.index'))->with('status', 'Administator updated successfully with roles.');
    }

    public function destroy($id)
    {
        $administrator = Admin::findOrFail($id);
        $administrator->delete();

        return redirect(route('admin.administrator.index'))->with('status', 'Administator deleted successfully.');
    }
}
