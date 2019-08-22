<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stall extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $guarded = [];

    public function stallTasks(){
        return $this->hasMany(StallTask::class);
    }
}
