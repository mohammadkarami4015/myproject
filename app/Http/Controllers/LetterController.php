<?php

namespace App\Http\Controllers;

use App\Letter;
use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:allLetter', ['only' => ['index']]);
        $this->middleware('permission:addLetter', ['only' => ['create', 'store']]);
    }

    public function index()
    {
//        $var =Verta::parse('22/09/1398 22:10');
//        dd( $var->DateTime()->format('Y-m-d H:i:s')); // 2017-05-23 23:21:02);

        $letters = Letter::latest()->get();
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
        $user = auth()->user()->code;
        $users = User::where([['code', 'like', $user . '%'], ['code', '!=', $user]])->get('id');

        if ($letter = Letter::whereIn('user_id', $users)->get()) {
            $letters = $letter;

        } else {
            $letters = collect();
        }
        return view('letter.index', compact('letters'));
    }


    public function getChilds()
    {
        $user = auth()->user()->code;
        $users = User::where([['code', 'like', $user . '%'], ['code', '!=', $user]])->get();
        return $users;
    }

    public function accessLetter()
    {
        $user = auth()->user();
        $lettersUser = $user->letters;
        $letters = $lettersUser->filter(function ($value) {
            return (($value->pivot->created_at <= Carbon::now() && $value->pivot->exp_time >= Carbon::now())
                || ($value->pivot->created_at <= Carbon::now() && $value->pivot->exp_time == null));
        });

        return view('letter.otherLetter', compact('letters'));

    }


    public function create()
    {

        $users = $this->getChilds();
        $time = Letter::time();
        return view('letter.create', compact('users', 'time'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|max:30',
            'details' => 'required|min:10',
        ]);

        $letter = Letter::create([
            'title' => $request->title,
            'details' => $request->details,
            'user_id' => auth()->user()->id
        ]);

        if ($request->has('user_id')) {
            foreach ($request->user_id as $userId) {
                $startTime = Letter::convertTime($request->start_date[$userId]);
                $expireTime = Letter::convertTime($request->expire_date[$userId]);
                if ($request->expire_date[$userId] != null) {
                    $letter->users()->attach($userId, [
                        'created_at' => $startTime,
                        'exp_time' => $expireTime,
                    ]);
                } else {
                    $letter->users()->attach($userId, ['created_at' => $startTime]);
                }
            }
        }
        $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت اضافه شد!...');
        return back();
    }

    public function show(Letter $letter)
    {

    }


    public function edit(Letter $letter)
    {
        if ($letter->isAllow()) {
            $users = $this->getChilds();
            return view('letter.edit', compact('letter', 'users'));
        } else
            return back()->withErrors('شما اجازه این عملیات را ندارید');
    }


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
                    $startTime = Letter::convertTime($request->start_date[$userId]);
                    $expireTime = Letter::convertTime($request->expire_date[$userId]);
                    if ($request->expire_date[$userId] != null) {
                        $letter->users()->attach($userId, [
                            'created_at' => $startTime,
                            'exp_time' => $expireTime,
                        ]);
                    } else {
                        $letter->users()->attach($userId, ['created_at' => $startTime]);
                    }
                }
            }


            $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت ویرایش شد.');
            return back();
        }

    }


    public function destroy(Request $request, Letter $letter)
    {
        $letter->delete();
        $request->session()->flash('flash_message', 'نامه مورد نطر با موفقیت حذف شد!...');
        return back();
    }

}
