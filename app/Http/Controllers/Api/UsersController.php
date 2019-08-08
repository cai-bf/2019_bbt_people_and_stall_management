<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Department;
use App\Models\Captcha;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;

class UsersController extends Controller
{
    public function get_user() {
        $user = auth()->user();
        $user = User::with(['department', 'group', 'detail' => function($q) {
            $q->with(['college']);
        }])->find($user->id);
        return $this->response->array($user->toArray());
    }

    public function store(Request $request) {
        $user = auth()->user();
        $group = $user->group;
        $department = $user->department;

        $group_pre = Group::where('name', $request->group)->first();
        $department_pre = Department::where('name', $request->department)->first();

        if ($group->id >= $group_pre->id)
            return $this->response->errorUnauthorized('权限不足');
        if ($group->id > CHANGWEI && $department->name != $request->department)
            return $this->response->errorUnauthorized('权限不足');

        \DB::beginTransaction();
        foreach($request->data as $v) {
            if (User::where('sno', $v['sno'])->first())
                return $this->response->errorBadRequest('已存在学号'.$v['sno']);
            $u = User::create([
                'sno' => $v['sno'],
                'password' => bcrypt('123456'),
                'group_id' => $group_pre->id,
                'department_id' => $department_pre->id
            ]);
            $u->assignRole($group_pre->name);
        }
        \DB::commit();

        return $this->response->noContent();
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string',
            'password2' => 'required|string|same:password'
        ]);
        
        $user = auth()->user();
        if (!User::checkPsd($request->old_password, $user->password))
            return $this->response->errorBadRequest('密码错误');
        $user->password = \bcrypt($request->password);
        $user->save();

        return $this->response->noContent();
    }

    public function sendPsdResetCaptcha(Request $request) {
        $request->validate([
            'sno' => 'required|string|size:12',
            'email' => 'required|email'
        ]);

        $user = User::where('sno', $request->sno)->with('detail')->first();
        if (!$user or $user->email !== $request->email)
            return $this->response->errorBadRequest('学号或对应邮箱错误');
        
        $random = strval(random_int(10000000, 99999999));
        
        Captcha::create([
            'type' => PSDRESET,
            'user_id' => $user->id,
            'captcha' => bcrypt($random),
            'expires_on' => date('Y-m-d H:i:s', strtotime('+10 minutes'))
        ]);

        Mail::to($user->email, $user->detail->name)->send(new PasswordReset($random));

        return $this->response->noContent();
    }
}
