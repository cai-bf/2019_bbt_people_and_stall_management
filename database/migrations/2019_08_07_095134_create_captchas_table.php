<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('captchas', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->comment('验证码类型(1.忘记密码,2.修改邮箱)');
            $table->integer('user_id')->index();
            $table->string('captcha');
            $table->timestamp('expires_on');
            $table->boolean('used')->default(0);
            $table->string('remark', 50)->nullable();
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
        Schema::dropIfExists('captchas');
    }
}
