<?php

use Illuminate\Database\Seeder;
use App\Models\UserStallNumber;

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Schedule::class,200)->create()->each(function($s){
            if (UserStallNumber::where('user_id',$s->user_id)->get()->isEmpty())
            UserStallNumber::create([
                'user_id'=>$s->user_id,
                'verified'=>1
            ]);
        });
    }
}
