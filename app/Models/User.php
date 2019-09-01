<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $guard_name = 'api';

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
        'password',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function detail() {
        return $this->hasOne(Detail::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function captcha() {
        return $this->hasOne(Captcha::class);
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

    public function stallNumber(){
        return $this->hasOne(UserStallNumber::class);
    }

    public function stallTasks(){
        return $this->belongsToMany(StallTask::class,'user_stall_task')->using(UserStallTask::class);
    }

    static public function checkPsd($password, $hashpsd) {
        return Hash::check($password, $hashpsd);
    }

}
