<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Department;

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
        if (!User::checkPassword($request->old_password, $user->password))
            return $this->response->errorBadRequest('密码错误');
        $user->password = \bcrypt($request->password);
        $user->save();

        return $this->response->noContent();
    }
}
