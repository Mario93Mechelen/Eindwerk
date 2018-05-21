<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrossingsLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crossings_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crossing_id')->unsigned()->index();
            $table->foreign('crossing_id')->references('id')->on('crossings')->onDelete('cascade');
            $table->double('latitude');
            $table->double('longitude');
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
        Schema::dropIfExists('crossings_locations');
    }
}
