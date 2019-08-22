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

        $department_id=Department::select('id')->where('name',$request->department)->first();
        Stall::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'department_id'=>$department_id,
        ]);

        return $this->response->noContent();
    }

    public function deleteStall($id){
        $user=auth()->user();
        $group = $user->group;
        $group_need=Group::where('name','部长')->first();
        $department = $user->department;
        $stall=Stall::find($id);
        if ($group->name < $group_need->level || $department->id != $stall->id)
            return $this->response->errorUnauthorized('权限不足');
        
        $stall->delete();
        return $this->response->noContent();
    }

    public function updateStall($id,Request $request){
        $stall=Stall::find($id);
        $department_id=Department::select('id')->where('name',$request->department)->first();
        $stall->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'department_id'=>$department_id,
        ]);
    }
    
    public function showStallList() {
        $stalls=Stall::all();
        return $this->response->array($stalls->toArray());
    }
}
