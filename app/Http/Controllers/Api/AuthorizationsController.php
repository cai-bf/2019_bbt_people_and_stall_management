<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;

class AuthorizationsController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('sno', 'password');

        if ($token = auth()->attempt($credentials)) {
            return $this->responseToken($token);
        }

        return $this->response->errorUnauthorized('学号或密码错误');
    }

    public function logout() {
        auth()->logout();

        return $this->response->array(['error' => 0, 'msg' => '成功退出登录']);
    }

    public function refresh() {
        return $this->responseToken(auth()->refresh());
    }

    public function responseToken($token) {
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
