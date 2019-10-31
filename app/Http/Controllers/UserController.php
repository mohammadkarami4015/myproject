<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Role;
use App\Traits\Coding;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Coding;

    public function __construct()
    {
        $this->middleware('permission:allUser', ['only' => ['index']]);
        $this->middleware('permission:addUser', ['only' => ['create','store']]);
        $this->middleware('permission:deleteUser', ['only' => ['destroy']]);
        $this->middleware('permission:editUser', ['only' => ['edit','update','updateRole']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('user.index',compact('users'));
    }

    public function childUser()
    {
       $user = auth()->user()->code;
        $users = User::where([['code','like',$user.'%'],['code','!=',$user]])->latest()->paginate(20);
        return view('user.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $user = User::create([
            'name'=>$request->name,
            'parent_id'=>$request->parent_id,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'code'=>$this->makeCode($request->parent_id),
        ]);
        if ($request->has('role_id'))
            $user->roles()->sync($request->input('role_id'));

        $request->session()->flash('flash_message', 'کاربر جدید با موفقیت ثبت شد');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,User $user)
    {

        $user->update([
           'name'=>$request->name,
           'parent_id'=>$request->parent_id,
           'email'=>$request->email,
           'password'=>bcrypt($request->password),
            'code'=>$this->makeCode($request->parent_id),
        ]);

        $request->session()->flash('flash_message', 'ویرایش کاربر با موفقیت انجام شد');
        return back();

    }
    public function updateRole(Request $request,User $user)
    {
        $user->roles()->sync($request->input('role_id'));

        $request->session()->flash('flash_message', 'ویرایش کاربر با موفقیت انجام شد');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

    public function editProfile(User $user)
    {
        return view('user.editProfile',compact('user'));
    }

    public function updateProfile(UserRequest $request,User $user)
    {

     $match =  Hash::check($request->old_password,$user->password);
      if(!$match)
           return back()->withErrors(' old password is invalid');

       $user->update([
           'name' =>$request->name,
           'email' =>$request->email,
           'password'=>bcrypt($request->password),
       ]);
        $request->session()->flash('flash_message', 'ویرایش پروفایل با موفقیت انجام شد');
        return auth()->logout() ?: redirect('/');
    }
}
