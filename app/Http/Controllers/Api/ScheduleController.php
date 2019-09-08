<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\UserStallNumber;
use Illuminate\Support\Facades\Storage;

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
        $user=User::findOrFail($id);
        $schedules=Schedule::where('user_id',$id)
            ->select(['day','class','week'])
            ->orderBy('day')
            ->orderBy('class')
            ->get()
            ->makeHidden(['day', 'class'])
            ->groupBy(['day','class'])
            ->each(function($day){
                $day->transform(function($class){
                    $newclass=array();
                    foreach($class as $week){
                        array_push($newclass,$week->week);
                    }
                    sort($newclass);
                    return $newclass;
                });
            });
        $usnumber=$user->stallNumber;

        return $this->response->array([
            'photo'=>$usnumber->photo,
            'schedule'=>$schedules->toArray()
        ]);
    }
    
    public function check($id){
        //验证
        $user=User::with('stallNumber')->find($id);
        $user->stallNumber->verified=1;
        $user->stallNumber->save();
        return $this->response->noContent();
    }

    public function uploadPic(Request $request){
        if (!in_array($request->file('schedule')->extension(), ['png', 'jpg', 'jpeg', 'gif']))
        return $this->response->errorBadRequest('目前只支持jpg, png, jpeg, gif格式');

        $user=auth()->user();
        $path=$request->file('schedule')->store('schedules','public');
        $stall_number=$user->stallNumber;
        $stall_number->update(['photo'=> Storage::url($path)]);

        return $this->response->array([
            'scheduler' => $stall_number->photo
        ]);
    }


}
