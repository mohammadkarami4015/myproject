<?php

namespace App;

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
        return $this->belongsToMany(User::class)->withPivot('exp_time');
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
            00, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23
        ];
        return $time;
    }
}
