<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermablesTable extends Migration
{
    /**
     * 
     */
    public function up()
    {
        Schema::create('termables', function (Blueprint $table) 
        {
            $table->integer('term_relation_id')->unsigned();
            $table->integer('termable_id')->unsigned();
            $table->string('termable_type');

            $table->foreign('term_relation_id')->references('id')->on('terms')->onDelete('cascade');
        });
    }

    /**
     * 
     */
    public function down()
    {
        Schema::drop('termables');
    }
}
