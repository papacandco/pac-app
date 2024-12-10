<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('podcasts', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('sections', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('technologies', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('newsletters', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('sections', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('technologies', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('newsletters', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
