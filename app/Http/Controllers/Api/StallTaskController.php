<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\StallTask;
use App\Models\Calendar;
use App\Models\Stall;
use App\Models\UserStallTask;
use stdClass;

class StallTaskController extends Controller
{
    private function dateToWeek($date)
    {
        $start_date = Calendar::where('date', '<', $date)->orderBy('date', 'desc')->first()->date;
        return (int) ceil((strtotime($date) - strtotime($start_date . " -1 day")) / (604800));
    }

    public function newTask(Request $request)
    {
        //验证
        StallTask::create([
            'stall_id' => $request->stall_id,
            'location' => $request->location,
            'date' => $request->date,
            'number' => $request->number,
            'start' => $request->start,
            'end' => $request->end
        ]);
        return $this->response->noContent();
    }

    public function deleteTask($id)
    {
        //验证
        StallTask::find($id)->delete();
        return $this->response->noContent();
    }

    public function updateTask($id, Request $request)
    {
        //验证
        //感觉不能使用更新
        StallTask::create([
            'location' => $request->location,
            'date' => $request->date,
            'number' => $request->number,
            'start' => $request->start,
            'end' => $request->end
        ]);
        return $this->response->noContent();
    }

    public function createList(Request $request)
    {
        //验证
        $task_id = $request->task_id;
        $task = StallTask::findOrFail($task_id);
        if (!UserStallTask::where('stall_task_id', $task_id)->where('role', '<>', 1)->get()->isEmpty())
            return $this->response->errorBadRequest('人员已分配！');
        $admin = UserStallTask::where([
            'stall_task_id' => $task_id,
            'role' => 1
        ])->get();
        if ($admin->isEmpty())
            return $this->response->errorBadRequest('请先添加负责人！');
        $week = $this->dateToWeek($task->date);
        $day = (int) date("w", strtotime($task->date));
        if ($day == 0) $day = 7;
        $stall = $task->stall;
        $same_stall_users_ids = $stall->userStallTask()->pluck('user_id')->toArray();
        $same_time_tasks_users_ids = User::whereHas('stallTasks', function ($q) use ($task) {
            $q->where([
                ['date', '=', $task->date],
                ['start', '<=', $task->end],
                ['end', '>=', $task->start]
            ]);
        })->pluck('id')->toArray();
        $users = User::with([
            'stallNumber',
        ])->whereHas('stallNumber', function ($q) {
            $q->where('verified', 1);
        })->whereHas('schedules', function ($q) use ($week, $day, $task) {
            $q->where([
                ['week', '=', $week],
                ['day', '=', $day],
                ['class', '>=', $task->start],
                ['class', '<=', $task->end]
            ]);
        })->get()
            ->shuffle()
            ->sortBy(function ($user, $key) use ($same_time_tasks_users_ids, $same_stall_users_ids) {
                if (in_array($user->id, $same_time_tasks_users_ids)) return 200000 + $user->stallNumber->number;
                else if (in_array($user->id, $same_stall_users_ids)) return 100000 + $user->stallNumber->number;
                else return $user->stallNumber->number;
            })
            ->take($task->number - 1);
        $users->each(function ($user, $key) use ($task) {
            $user->stallTasks()->attach($task->id);
        });
        return $this->response->noContent();
    }

    public function addTaskAdmin($id, Request $request)
    {
        //验证 
        $user_sno = $request->sno;
        $task_id = $id;
        $user = User::where('sno', $user_sno)->first();
        $task = StallTask::findOrFail($task_id);
        $admin = UserStallTask::where(['stall_task_id' => $task_id, 'role' => 1])->get();
        if (!$admin->isEmpty())
            return $this->response->errorBadRequest('已存在负责人！');
        $user->stallTasks()->attach($task_id, ['role' => 1]);
        $user->stallNumber()->increment('number');
        return $this->response->noContent();
    }

    public function deleteTaskAdmin($id)
    {
        //验证 
        $task_id = $id;
        $task = StallTask::findOrFail($task_id);
        $admin = UserStallTask::where(['stall_task_id' => $task_id, 'role' => 1])->delete();
        return $this->response->noContent();
    }

    public function checkIn($id, Request $request)
    {
        //验证
        $user_id = $request->user_id;
        $task_id = $id;
        $user = User::find($user_id);
        $user->stallTasks()->updateExistingPivot($task_id, ['check_in' => 1]);
        $user->stallNumber->increment('number');
        return $this->response->noContent();
    }

    public function showTask($id)
    {
        $task = StallTask::find($id);
        return $this->response->array($task->toArray());
    }

    public function showTaskList($id)
    {
        $stall = Stall::find($id);
        $tasks = $stall->stallTasks;
        return $this->response->array($tasks->toArray());
    }

    public function showTaskMember($id)
    {
        $users = User::with([
            'detail' => function ($q) {
                $q->select(['user_id', 'name', 'sex', 'mobile']);
            },
            'stallTasks' => function ($q) use ($id) {
                $q->where('stall_task_id', $id)->select(['user_id', 'role', 'check_in']);
            },
        ])->whereHas('stallTasks', function ($q) use ($id) {
            $q->where('stall_task_id', $id);
        })->get()
            ->makeHidden(['created_at', 'updated_at', 'email', 'deleted_at'])
            ->each(function ($user, $key) {
                $status = $user->stallTasks;
                unset($user->stallTasks);
                $user->stallTasks = new stdClass;
                $user->stallTasks->role = $status[0]->role;
                $user->stallTasks->check_in = $status[0]->check_in;
                $user->detail->makeHidden('user_id');
            });
        return $this->response->array($users->toArray());
    }

}
