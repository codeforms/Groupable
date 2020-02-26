<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * 
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('language_id')->unsigned()->nullable();
            $table->integer('groupable_id')->unsigned();
            $table->string('groupable_type');
            $table->timestamps();

            $table->foreign('parent_id')
                    ->references('id')
                    ->on('group')
                    ->onDelete(DB::raw('set null'))
                    ->onUpdate('cascade');
        });
    }

    /**
     * 
     */
    public function down()
    {
        Schema::drop('group');
    }
}
