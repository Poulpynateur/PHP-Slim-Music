<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_tag', function (Blueprint $table) {
            $table->integer('music_id')->unsigned();
            $table->integer('tag_id')->unsigned();
        });

        Schema::table('music_tag', function($table) {
            $table->foreign('music_id')->references('id')->on('musics');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('music_tag');
    }
}
