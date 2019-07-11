<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

/**
 * Class CreateNavigationsTable
 */
class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('language_id')->unsigned()->nullable()->index();
            $table->string('name');
            $table->string('slug');
            $table->string('full_slug');
            $table->boolean('is_visible');
            $table->boolean('is_active');

            $table->string('scope')->index();
            NestedSet::columns($table);

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navigations');
    }
}
