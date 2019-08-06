<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function get_user() {
        $user = auth()->user();
        return $this->response->array($user->toArray());
    }
}
