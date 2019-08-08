<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Captcha extends Model
{
    protected $guarded = [];

    static public function checkCaptcha($captcha, $hashed) {
        return Hash::check($captcha, $hashed);
    }
}
