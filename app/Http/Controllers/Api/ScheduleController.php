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
        if ($user->stallNumber()->isEmpty()){
            UserStallNumber::create([
                'user_id'=>$id,   
            ]);
        }else {
            $user->number->update(['verified'=>0]);
        }
        Schedule::where('user_id',id)->delete();
        $schedules=$request->schedules;
        foreach($schedules as $s){
            for($i=$s['start'];$i<=$s['end'];$i++){
                Schedule::create([
                    'user_id'=>$id,
                    'weak'=>$i,
                    'day'=>$s['day'],
                    'class'=>$s['class']
                ]);
            }
        }
    }

    public function show($id){
        $user=User::with(['stallNumber','schedules'=>function($q){
            $q->select('week','day','class');
        }])->find($id);
        return $this->response->array($user->toArray());
    }
    
    public function checkSchedule($id){
        //验证
        $user=User::with('stallNumber')->find($id);
        $user->stallNumber->verified=1;
        $user->stallNumber->save();

    }
}
