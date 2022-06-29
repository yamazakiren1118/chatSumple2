<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('room_id');
            // $table->string('user_name')->nullable();

            // 下記２つのカラムは未読通知のためのもの
            // 最新のメッセージIDとメッセージを投稿したユーザーを保存する
            $table->bigInteger('message_user')->nullable();
            $table->bigInteger('message_id')->nullable();
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
        Schema::dropIfExists('direct_user');
    }
}
