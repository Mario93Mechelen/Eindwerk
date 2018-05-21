<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrossingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crossings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crosser_id')->unsigned()->index();
            $table->integer('crossed_id')->unsigned()->index();
            $table->foreign('crosser_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('crossed_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('meeting')->default(0);
            $table->boolean('contacted')->default(0);
            $table->boolean('seen')->default(0);
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
        Schema::dropIfExists('crossings');
    }
}
