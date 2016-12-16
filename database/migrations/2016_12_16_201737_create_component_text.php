<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_texts', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('page_component_id')->unsigned()->index();
            $table->string('headline');
            $table->text('body');
            $table->timestamps();

            //$table->foreign('page_component_id')->references('id')->on('page_components')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('component_texts');
    }
}
