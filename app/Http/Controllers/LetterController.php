<?php

namespace App\Http\Controllers;

use App\Letter;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\EventListener\DisallowRobotsIndexingListener;

class LetterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manageLetter', ['only' => ['index']]);
        $this->middleware('permission:addLetter', ['only' => ['create', 'store']]);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $letters = Letter::latest()->paginate(10);
        return view('letter.index', compact('letters'));
    }


    public function myIndex()
    {
        $user = auth()->user()->id;
        $letters = Letter::whereUser_id($user)->latest()->paginate(10);
        return view('letter.index', compact('letters'));
    }

    public function childLetter()
    {
        if ($user = auth()->user()->childs()->get('id')->toArray()) {
            $letters = Letter::whereUser_id($user)->latest()->paginate(10);
        } else
            $letters = collect();
        return view('letter.index', compact('letters'));

    }

    public function accessLetter()
    {
        $user = auth()->user();
        $lettersUser = $user->letters;
        $letters = $lettersUser->filter(function ($value) {
            return $value->pivot->exp_time >= Carbon::now() || $value->pivot->exp_time == null;
        });
        return view('letter.index', compact('letters'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $users = $user->childs;
        return view('letter.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
            'details' => 'required|min:10',
        ]);

        if (auth()->check()) {
            $letter = Letter::create([
                'title' => $request->title,
                'details' => $request->details,
                'user_id' => auth()->user()->id
            ]);

            if ($request->has('user_id')) {
                foreach ($request->user_id as $userId) {
                    if ($request->exp_time[$userId] != null)
                        $letter->users()->attach($userId, ['exp_time' => Carbon::parse("+" . $request->exp_time[$userId] . " hour")]);
                    else
                        $letter->users()->attach($userId);
                }
//
            }
            $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت اضافه شد!...');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter)
    {
        return view('letter.details', compact('letter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function edit(Letter $letter)
    {

        if ($letter->isAllow()) {
            $user = auth()->user();
            $users = $user->childs;
            return view('letter.edit', compact('letter', 'users'));
        } else
            return back()->withErrors('شما اجازه این عملیات را ندارید');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Letter $letter)
    {

        $this->validate($request, [
            'title' => 'required|max:30',
            'details' => 'required|min:10',
        ]);

        if ($letter->isAllow()) {
            $letter->update([
                'title' => $request->title,
                'details' => $request->details
            ]);

            $letter->users()->detach();

            if ($request->has('user_id')) {
                foreach ($request->user_id as $userId) {
                    if ($request->exp_time[$userId] != null)
                        $letter->users()->attach($userId, ['exp_time' => Carbon::parse("+" . $request->exp_time[$userId] . " hour")]);
                    else
                        $letter->users()->attach($userId);
                }
            }
            $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت ویرایش شد!...');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Letter $letter)
    {

        $letter->delete();
        $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت حذف شد!...');
        return back();

    }
}
