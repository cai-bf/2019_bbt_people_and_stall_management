<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStallTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stall_task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('stall_task_id');
            $table->tinyInteger('role')->nullable()->default(0);
            $table->tinyInteger('check_in')->nullable()->default(0);
            $table->timestamps();
            $table->unique(['user_id','stall_task_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_stall_task');
    }
}
