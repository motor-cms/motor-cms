<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageIdToNavigations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('navigations', function (Blueprint $table) {
            $table->integer('page_id')->unsigned()->index()->nullable()->after('slug');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('navigations', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropColumn('page_id');
        });
    }
}
