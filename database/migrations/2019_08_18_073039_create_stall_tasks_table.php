<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStallTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stall_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stall_id');
            $table->string('location')->default('');
            $table->date('date');
            $table->integer('number');
            $table->tinyInteger('start');
            $table->tinyInteger('end');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stall_tasks');
    }
}
