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
            $table->integer('groupable_id')->unsigned();
            $table->string('groupable_type');
            $table->timestamps();
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
