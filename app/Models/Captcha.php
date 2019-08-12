<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class Captcha extends Model
{
    protected $guarded = [];

    protected static function boot() {
        parent::boot();

        static::addGlobalScope('notUsed', function(Builder $builder) {
            $builder->where('used', 0);
        });
    }

    static public function checkCaptcha($captcha, $hashed) {
        return Hash::check($captcha, $hashed);
    }
}
