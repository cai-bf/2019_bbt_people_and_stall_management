<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stall;
use App\Models\Department;
use App\Models\Group;
use App\Models\User;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use stdClass;

class StallController extends Controller
{    
    public function newStall(Request $request){
        //验证
        $stall=Stall::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'department_id'=>$request->department_id,
        ]);

        return response()->json([
            "id"=>$stall->id
        ]);
    }

    public function deleteStall($id){
        $user=auth()->user();
        $group = $user->group;
        $group_need=Group::where('name','部长')->first();
        $department = $user->department;
        $stall=Stall::find($id);
        if ($group->level < $group_need->level || $department->id != $stall->department_id)
            return $this->response->errorUnauthorized('权限不足');
        $stall->delete();
        return $this->response->noContent();
    }

    public function updateStall($id,Request $request){
        $user=auth()->user();
        $group = $user->group;
        $group_need=Group::where('name','部长')->first();
        $department = $user->department;
        $stall=Stall::find($id);
        if ($group->level < $group_need->level || $department->id != $stall->department_id)
            return $this->response->errorUnauthorized('权限不足');
        $stall->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'department_id'=>$request->department_id,
        ]);
        return $this->response->noContent();
    }
    
    public function showStall($id=0) {
        if ($id) $stalls=Stall::with(['stallTasks'=>function($q){
            $q->select(['stall_id',DB::raw('count(*) as tasks_number')])->groupBy('stall_id');
        }])->find($id);
        else $stalls=Stall::with(['stallTasks'=>function($q){
            $q->select(['stall_id',DB::raw('count(*) as tasks_number')])->groupBy('stall_id');
        }])->get();
        return $this->response->array($stalls->toArray());
    }

    public function export($id){
        $stall=Stall::findOrFail($id);
        $sheets=array();
        $tasks=$stall->stallTasks;
        $tasks->each(function($task)use(&$sheets){
            $title=date('d',strtotime($task->date))."日".$task->location.$task->start.$task->end."节";
            $task_id=$task->id;
            $users = User::with([
                'detail' => function ($q) {
                    $q->select(['user_id', 'name', 'sex', 'mobile']);
                },
                'stallTasks' => function ($q) use ($task_id) {
                    $q->where('stall_task_id', $task_id)->select(['user_id', 'role']);
                },
                'department'
            ])->whereHas('stallTasks', function ($q) use ($task_id) {
                $q->where('stall_task_id', $task_id);
            })->get()
                ->makeHidden(['id','sno','created_at', 'updated_at', 'email', 'deleted_at'])
                ->transform(function ($user) {
                    $old_user=$user;
                    $user=new stdClass;
                    $user->name=$old_user->detail->name;
                    $user->sex=$old_user->sex;
                    $user->department=$old_user->department->name;
                    $user->mobile=$old_user->detail->mobile;
                    $user->role=($old_user->stallTasks[0]->role)?"负责人":"";
                    return $user;
                });
            if (!$users->isEmpty())$sheets[$title]=$users;
        });

        $exsheets = new SheetCollection($sheets);
 
        $filename=$stall->name."摆摊安排.xlsx";

        $filepath=public_path('storage\\excel\\'.$filename);
        (new FastExcel($exsheets))->export($filepath);

        return $this->response->array(['path'=>'storage\\excel\\'.$filename]);

    }

}
