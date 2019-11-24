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

    public static function convertTime($time)
    {
        $var = Verta::parse($time);
        return $var->DateTime()->format('Y-m-d H:i:s');
    }

    public static function attachDateInPivot(array $user_id, $str_date, $end_date, $letter)
    {
        if ($user_id) {
            foreach ($user_id as $userId) {
                $startTime = Letter::convertTime($str_date[$userId]);
                $expireTime = Letter::convertTime($end_date[$userId]);
                if ($end_date[$userId] != null) {
                    $letter->users()->attach($userId, [
                        'created_at' => $startTime,
                        'exp_time' => $expireTime,
                    ]);
                } else {
                    $letter->users()->attach($userId, ['created_at' => $startTime]);
                }
            }
        }

    }
}
