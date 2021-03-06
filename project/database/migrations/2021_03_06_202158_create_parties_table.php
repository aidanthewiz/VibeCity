<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partyCreator');
            $table->foreignId('joinCode')->nullable();
            $table->timestamps();
            $table->boolean('partyOpen')->nullable();
            $table->boolean('kickEnabled')->default(false);
            $table->string("song_uri")->nullable();
            $table->integer('song_start_time')->nullable();
            $table->integer('position')->nullable();
            $table->boolean("playing")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parties');
    }
}
