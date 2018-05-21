<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('friend_sender')->unsigned()->index();
            $table->integer('friend_receiver')->unsigned()->index();
            $table->foreign('friend_sender')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('friend_receiver')->references('id')->on('users')->onDelete('cascade');
            $table->enum('request_type',['sent','pending','friends','none'])->default('none');
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
        Schema::dropIfExists('friends');
    }
}
