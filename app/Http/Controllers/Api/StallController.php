<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Stall;
use App\Models\Department;
use App\Models\Group;

class StallController extends Controller
{    
    public function newStall(Request $request){
        //验证
        Stall::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'department_id'=>$request->department_id,
        ]);

        return $this->response->noContent();
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
        if ($id) $stalls=Stall::find($id);
        else $stalls=Stall::all();
        return $this->response->array($stalls->toArray());
    }

}
