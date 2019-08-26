<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\UserStallNumber;

class ScheduleController extends Controller
{
    public function store(Request $request) {
        $id=$request->id;
        $user=User::find($id);
        if (!$user->stallNumber){
            UserStallNumber::create([
                'user_id'=>$id,   
            ]);
        }else {
            $user->stallNumber->update(['verified'=>0]);
        }
        Schedule::where('user_id',$id)->delete();
        $schedules=$request->schedules;
        foreach($schedules as $s){
            for($i=$s['start'];$i<=$s['end'];$i++){
                Schedule::create([
                    'user_id'=>$id,
                    'week'=>$i,
                    'day'=>$s['day'],
                    'class'=>$s['class']
                ]);
            }
        }
        return $this->response->noContent();
    }

    public function show($id){
        $schedules=Schedule::where('user_id',$id)
            ->select(['day','class','week'])
            ->orderBy('day')
            ->orderBy('class')
            ->get()
            ->groupBy(['day','class']);
            
        return $this->response->array($schedules->toArray());
    }
    
    public function check($id){
        //验证
        $user=User::with('stallNumber')->find($id);
        $user->stallNumber->verified=1;
        $user->stallNumber->save();
        return $this->response->noContent();
    }
}
