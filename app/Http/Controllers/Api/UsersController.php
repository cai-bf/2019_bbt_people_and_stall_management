<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Department;
use App\Models\Captcha;
use App\Models\Detail;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;
use App\Mail\EmailReset;
use Illuminate\Database\Eloquent\Builder;

class UsersController extends Controller
{
    public function index() {
        $users = User::with(['department', 'group', 'detail' => function($query) {
            $query->select(['user_id', 'name', 'sex']);
        }])->orderBy('group_id')->orderBy('department_id')->paginate(PER_PAGE);
        return $this->response->array($users);
    }

    public function getDepartment() {
        $users = User::where('department_id', auth()->user()->department_id)
                    ->with(['department', 'group', 'detail' => function($query) {
                        $query->select(['user_id', 'name', 'sex']);
                    }])->orderBy('group_id')->paginate(PER_PAGE);
        return $this->response->array($users);
    }

    public function getGroup() {
        $users = User::where('group_id', auth()->user()->group_id)
                    ->with(['department', 'group', 'detail' => function($query) {
                        $query->select(['user_id', 'name', 'sex']);
                    }])->orderBy('group_id')->paginate(PER_PAGE);
        return $this->response->array($users);
    }

    public function get_user($id = 0) {
        $user = auth()->user();
        $user = User::withTrashed()->with(['department', 'group', 'detail' => function($q) {
            $q->with(['college']);
        }])->find(($id ? $id : $user->id));
        return $this->response->array($user->toArray());
    }

    public function recycleIndex() {
        $users = User::with(['department', 'group', 'detail' => function($query) {
            $query->select(['user_id', 'name', 'sex']);
        }])->onlyTrashed()->paginate(PER_PAGE);

        return $this->response->array($users);
    }

    public function search(Request $request) {
        $request->validate([
            'query' => 'required|string'
        ]);
        $q = $request->input('query');

        $users = User::withTrashed()->whereHas('detail', function (Builder $query) use ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('major', 'like', "%$q%")
                ->orWhere('mobile', 'like', "%$q%")
                ->orWhere('shortMobile', 'like', "%$q%")
                ->orWhere('qq', 'like', "%$q%")
                ->orWhere('weibo', 'like', "%$q%");
        })->orWhereHas('group', function (Builder $query) use ($q) {
            $query->where('name', 'like', "%$q%");
        })->orWhereHas('department', function(Builder $query) use ($q) {
            $query->where('name', 'like', "%$q%");
        })->with(['department', 'group', 'detail' => function($query) {
            $query->select(['user_id', 'name', 'sex']);
        }])->orderBy('group_id')->paginate(PER_PAGE);

        return $this->response->array($users->toArray());
    }

    public function BBTLibrary(Request $request) {
        $request->validate([
            'year' => 'string|size:4',
            'department_id' => 'integer|between:1,' . Department::count()
        ]);

        $users = User::withTrashed()->with(['department', 'group', 'detail' => function($query) {
            $query->select(['user_id', 'name', 'sex']);
        }])->when($request->year, function($query) use ($request) {
            $query->where('sno', 'like', $request->year.'%');
        })->when($request->department_id, function($query) use ($request) {
            $query->where('department_id', $request->department_id);
        })->paginate(PER_PAGE);

        return $this->response->array($users->toArray());
    }

    public function store(Request $request) {
        $user = auth()->user();
        $group = $user->group;
        $department = $user->department;

        $group_pre = Group::where('name', $request->group)->first();
        $department_pre = Department::where('name', $request->department)->first();

        if ($group->level <= $group_pre->level)
            return $this->response->errorUnauthorized('权限不足');
        if ($group->name == '部长' && $department->name != $request->department)
            return $this->response->errorUnauthorized('权限不足');

        \DB::beginTransaction();
        foreach($request->data as $v) {
            if (User::where('sno', $v['sno'])->first())
                return $this->response->errorBadRequest('已存在学号'.$v['sno'].',请检查后重新添加');
            $u = User::create([
                'sno' => $v['sno'],
                'password' => bcrypt('123456'),
                'group_id' => $group_pre->id,
                'department_id' => $department_pre->id
            ]);
            $u->assignRole($group_pre->name);

            Detail::create([
                'user_id' => $u->id,
                'sex' => '不明',
                'avatar' =>'avatar/default.jpg',
                'name' => '',
                'birth' => '2000-01-01',
                'mobile' => '0'
            ]);
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

    public function delete(User $user) {
        $current = auth()->user();

        if ($current->group->name == '部长' && $current->department_id != $user->department_id)
            return $this->response->errorUnauthorized('权限不足');
        if ($current->group->level <= $user->group->level)
            return $this->response->errorUnauthorized('权限不足');
        
        $user->delete();

        return $this->response->noContent();
    }

    public function recycle($id) {
        $user = User::withTrashed()->find($id);
        $current = auth()->user();

        if ($current->group->name == '部长' && $current->department_id != $user->department_id)
            return $this->response->errorUnauthorized('权限不足');
        if ($current->group->level <= $user->group->level)
            return $this->response->errorUnauthorized('权限不足');
        
        $user->restore();

        return $this->response->noContent();
    }

    public function update($id, Request $request) {
        $request->validate([
            'group_id' => 'required|integer|between:1,' . Group::count(),
            'department_id' => 'required|integer|between:1,' . Department::count()
        ]);

        $user = User::withTrashed()->find($id);
        $current = auth()->user();
        $group = Group::find($request->group_id);

        if ($current->group->name == '部长' && $user->department_id !== $current->department_id)
            return $this->response->errorUnauthorized('权限不足');
        if ($current->group->level < $group->level)
            return $this->response->errorUnauthorized('权限不足');

        $user->update([
            'group_id' => $group->id,
            'department_id' => $request->department_id
        ]);

        $user->syncRoles([$group->name]);
        
        return $this->response->array($user->toArray());
    }

    public function sendPsdResetCaptcha(Request $request) {
        $request->validate([
            'sno' => 'required|string|size:12',
            'email' => 'required|email'
        ]);

        $user = User::where('sno', $request->sno)->first();
        if (!$user || $user->email !== $request->email)
            return $this->response->errorBadRequest('学号或对应邮箱错误');
        
        $captcha = getCaptcha();
        
        Captcha::create([
            'type' => PSDRESET,
            'user_id' => $user->id,
            'captcha' => bcrypt($captcha),
            'expires_on' => date('Y-m-d H:i:s', strtotime('+10 minutes'))
        ]);

        Mail::to($user->email)->send(new PasswordReset($captcha));

        return $this->response->noContent();
    }

    public function resetPsd(Request $request) {
        $request->validate([
            'sno' => 'required|string|size:12',
            'captcha' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('sno', $request->sno)->first();
        $captcha = $user->captcha()->where('type', PSDRESET)
                    ->where('expires_on', '>', date('Y-m-d H:i:s'))
                    ->orderByDesc('expires_on')
                    ->first();
        
        if (!$user)
            return $this->response->errorBadRequest('学号错误');
        if (!$captcha || !Captcha::checkCaptcha($request->captcha, $captcha->captcha))
            return $this->response->errorBadRequest('验证码错误或已过期');
        
        $captcha->update(['used' => 1]);
        $user->update(['password' => bcrypt($request->password)]);

        return $this->response->noContent();
    }

    public function sendChangeEmailCaptcha(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = auth()->user();
        $captcha = getCaptcha();

        Captcha::create([
            'type' => \EMAILRESET,
            'user_id' => $user->id,
            'captcha' => \bcrypt($captcha),
            'expires_on' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
            'remark' => $request->email
        ]);

        Mail::to($request->email)->send(new EmailReset($captcha));

        return $this->response->noContent();
    }

    public function resetEmail(Request $request) {
        $request->validate([
            'captcha' => 'required|string'
        ]);

        $captcha = auth()->user()->captcha()->where('type', \EMAILRESET)
                    ->where('expires_on', '>', date('Y-m-d H:i:s'))
                    ->orderByDesc('expires_on')
                    ->first();
        
        if (!$captcha || !Captcha::checkCaptcha($request->captcha, $captcha->captcha))
            return $this->response->errorBadRequest('验证码错误或已过期');
        
        $captcha->update(['used' => 1]);
        auth()->user()->update(['email' => $captcha->remark]);

        return $this->response->noContent();
    }
}
