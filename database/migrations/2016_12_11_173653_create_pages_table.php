<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePagesTable
 */
class CreatePagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('language_id')->unsigned()->nullable()->index();
            $table->boolean('is_active');
            $table->string('template');
            $table->string('name');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->string('state')->index();

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');
        });

        Schema::create('page_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('versionable_state')->index();
            $table->integer('versionable_number')->index();
            $table->integer('versionable_id')->unsigned()->index();
            $table->boolean('is_active');
            $table->string('template');
            $table->string('name');
            $table->string('meta_description');
            $table->string('meta_keywords');

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);
            $table->timestamps();

            $table->foreign('versionable_id')->references('id')->on('pages')->onDelete('cascade');
        });

        Schema::create('page_version_components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_version_id')->unsigned()->index();
            $table->string('container');
            $table->integer('sort_position')->unsigned();
            $table->string('component_name');
            $table->string('component_type');
            $table->string('component_id');
            $table->timestamps();

            $table->foreign('page_version_id')->references('id')->on('page_versions')->onDelete('cascade');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('page_version_components');
        Schema::drop('page_versions');
        Schema::drop('pages');
    }
}
