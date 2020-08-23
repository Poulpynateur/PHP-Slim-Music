<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('thumbnail_url')->nullable();
            $table->string('url')->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->boolean('has_children')->default(false);
            $table->timestamps();
        });

        Schema::table('notes', function($table) {
            $table->foreign('parent_id')
            ->references('id')->on('notes')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
