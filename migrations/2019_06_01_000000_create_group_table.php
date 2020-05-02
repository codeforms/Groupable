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
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('language_id')->unsigned()->nullable();
            $table->morphs('groupable');
            $table->timestamps();
        });

        Schema::create('terms', function (Blueprint $table) 
        {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->morphs('termable');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('termables', function (Blueprint $table) 
        {
            $table->integer('term_relation_id')->unsigned();
            $table->morphs('termable');
        });
    }

    /**
     * 
     */
    public function down()
    {
        Schema::drop('group');
        Schema::drop('terms');
        Schema::drop('termables');
    }
}
