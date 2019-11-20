<?php

namespace App;

use App\Traits\Coding;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function letter()
    {
        return $this->hasMany(Letter::class);
    }

    public function letters()
    {
        return $this->belongsToMany(Letter::class)->withPivot('exp_time');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);

    }

    public function childs()
    {
        return $this->hasMany(User::class,'parent_id');

    }
    public function parent()
    {
        return $this->belongsTo(User::class,'parent_id');

    }

    public function hasPermission($permission)
    {

        if ($this->roles->map->permissions->flatten()->pluck('title')->contains($permission)) {
            return true;
        }

        return false;
    }

}
