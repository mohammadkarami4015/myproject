<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:allRole');
        $this->middleware('permission:addRole',['only' => ['create', 'store']]);
        $this->middleware('permission:deleteRole',['only' => ['destroy']]);
        $this->middleware('permission:editRole',['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->paginate(20);
        return view('role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30',

        ]);

        $role = Role::create([
            'title' => $request->input('title'),
        ]);

        $role->permissions()->sync($request->input('permission_id'));
        $request->session()->flash('flash_message', 'نقش مورد نطر با موفقیت اضافه شد!...');
        return back();
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('role.edit', compact('role','permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
        ]);
        $role->update([
            'title' =>$request->title,
        ]);
        $role->permissions()->sync($request->input('permission_id'));
        $request->session()->flash('flash_message', 'نقش مورد نطر با موفقیت ویرایش شد!...');
        return back();
    }

    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        $request->session()->flash('flash_message', 'نقش مورد نطر با موفقیت حذف شد!...');
        return back();
    }
}
