<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
    /**
     * 
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('termable_id')->unsigned();
            $table->string('termable_type');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * 
     */
    public function down()
    {
        Schema::drop('terms');
    }
}
