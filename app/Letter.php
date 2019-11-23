<?php

namespace App;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['created_at', 'exp_time']);
    }

    public function isAllow()
    {
        $user = auth()->user()->id;
        if ($this->user_id == $user) {
            return true;
        } else
            return false;
    }

    public static function time()
    {
        $time = [
             1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,
            '24'=>'یک روز',
            '48'=>'دو روز',
            '72'=>'سه روز',
            '96'=>'چهار روز',
            '120'=>'پنج روز',
            '168'=>'یک هفته',
        ];
        return $time;
    }

    public static function convertTime($time)
    {
//        $strClock = explode(':', $time);
//        return (new Carbon)->createFromTime($strClock[0], $strClock[1]);
        $var =Verta::parse($time);
        return $var->DateTime()->format('Y-m-d H:i:s');

    }
}
