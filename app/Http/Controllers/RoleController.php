<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
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
            'label' => 'required|max:30'
        ]);

        $role = Role::create([
            'title' => $request->input('title'),
            'label' => $request->input('label'),
        ]);

        $role->permissions()->sync($request->input('permission_id'));

        $request->session()->flash('flash_message', 'record was successful added!...');
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
            'label' => 'required|max:30'
        ]);
        $role->update([
            'title' =>$request->title,
            'label' =>$request->label,
        ]);
        $role->permissions()->sync($request->input('permission_id'));
        // Display a Message
        $request->session()->flash('flash_message', 'record was successful updated!...');
        // redirect back()
        return back();
    }

    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        // Display a Message
        $request->session()->flash('flash_message', 'record was successful updated!...');
        // redirect back()
        return back();
    }
}
