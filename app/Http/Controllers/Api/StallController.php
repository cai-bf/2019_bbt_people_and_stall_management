<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stall;
use App\Models\Department;
use App\Models\Group;

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
        }])->all();
        return $this->response->array($stalls->toArray());
    }

}
