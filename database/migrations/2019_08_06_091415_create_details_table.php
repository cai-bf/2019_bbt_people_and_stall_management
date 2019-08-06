<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('name');
            $table->enum('sex', ['男', '女', '不明']);
            $table->string('avatar');
            $table->string('dormitory', 5)->nullable()->comment('宿舍楼');
            $table->string('room', 4)->nullable()->comment('宿舍房号');
            $table->string('major', 30)->nullable()->comment('专业名称');
            $table->date('birth');
            $table->string('origin', 30)->nullable()->comment('户籍');
            $table->string('politics', 30)->nullable()->comment('政治面貌');
            $table->string('mobile', 11);
            $table->string('shortMobile', 6)->nullable();
            $table->string('qq', 13)->nullable();
            $table->string('weibo', 30)->nullable();
            $table->tinyInteger('college_id')->nullable();
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
        Schema::dropIfExists('details');
    }
}
