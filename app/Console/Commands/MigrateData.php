<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Detail;
use Illuminate\Support\Facades\DB;

class MigrateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data-migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate old database data to new database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $old_users = DB::connection('mysql_old')->table('mm_users')
                    ->join('mm_details', 'mm_users.id', '=', 'mm_details.user_id')->get();
        DB::connection('mysql_old')->beginTransaction();
        try {
            DB::table('users')->truncate();
            DB::table('details')->truncate();
            foreach($old_users as $user) {
                $u = User::create([
                    'sno' => $user->num,
                    'group_id' => $user->group_id,
                    'department_id' => $user->department_id,
                    'password' => \bcrypt('123456'),
                    'deleted_at' => $user->isDeleted == 1 ? date('Y-m-d H:i:s') : null,
                    'created_at' => $user->created
                ]);
                $u->assignRole($u->group_id);
    
                Detail::create([
                    'user_id' => $u->id,
                    'name' => $user->name,
                    'sex' => $user->sex == '' ? '不明' : $user->sex,
                    'avatar' => '/storage/avatars/default.jpg',
                    'dormitory' => $user->dormitory,
                    'room' => $user->room,
                    'college_id' => $user->college_id == null ? 0 : $user->college_id,
                    'major' => $user->major,
                    'class' => $user->class,
                    'birth' => $user->birth,
                    'origin' => $user->origo,
                    'politics' => $user->politics,
                    'mobile' => $user->mobile,
                    'shortMobile' => $user->shortMobile,
                    'qq' => $user->qq,
                    'weibo' => $user->weibo,
                    'created_at' => $user->created
                ]);
            }
        } catch (Exception $exception) {
            DB::connection('mysql_old')->rollBack();
        }
        DB::connection('mysql_old')->commit();
    }
}
