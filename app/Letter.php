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
}
