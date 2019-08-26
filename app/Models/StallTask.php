<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StallTask extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $guarded = [];

    public function stall(){
        return $this->belongsTo(Stall::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->using(UserStallTask::class);
    }

    public function userStallTasks(){
        return $this->hasMany(UserStallTask::class);
    }
}
