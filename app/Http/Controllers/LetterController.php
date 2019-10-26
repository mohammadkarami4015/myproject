<?php

namespace App\Http\Controllers;

use App\Letter;
use App\User;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letters = Letter::latest()->paginate(20);
        return view('letter.index',compact('letters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return  view('letter.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'title' => 'required|max:30',
            'details' => 'required|min:10',
        ]);
        if(auth()->check()){
           $letter =  Letter::create([
               'title'=>$request->title,
               'details'=>$request->details,
                'user_id'=>auth()->user()->id
            ]);
           $letter->users()->attach($request->id,$request->user_id,$request->exp_time);

            $letter->users()->sync([$request->id => ['user_id' => 3]]);

            $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت اضافه شد!...');
            return back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter)
    {
        return view('letter.details',compact('letter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function edit(Letter $letter)
    {
        $users = User::all();
        return view('letter.edit',compact('letter','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Letter $letter)
    {

        $this->validate($request, [
            'title' => 'required|max:30',
            'details' => 'required|min:10',
        ]);
        if(auth()->check()){
            $letter->update([
                'title'=>$request->title,
                'details'=>$request->details
            ]);
            $letter->users()->sync($request->input('user_id'));
            $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت ویرایش شد!...');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Letter $letter)
    {
        $letter->delete();
        $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت حذف شد!...');
        return back();

    }
}
