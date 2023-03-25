<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->id();
            $table->bigInteger('client_id')->unsigned()->index();
            $table->bigInteger('language_id')->unsigned()->nullable()->index();
            $table->boolean('is_active');
            $table->string('template');
            $table->string('name');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->string('state')->index();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');
        });

        Schema::create('page_versions', function (Blueprint $table) {
            $table->id();
            $table->string('versionable_state')->index();
            $table->bigInteger('versionable_number')->index();
            $table->bigInteger('versionable_id')->unsigned()->index();
            $table->boolean('is_active');
            $table->string('template');
            $table->string('name');
            $table->string('meta_description');
            $table->string('meta_keywords');

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('versionable_id')->references('id')->on('pages')->onDelete('cascade');
        });

        Schema::create('page_version_components', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('page_version_id')->unsigned()->index();
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
