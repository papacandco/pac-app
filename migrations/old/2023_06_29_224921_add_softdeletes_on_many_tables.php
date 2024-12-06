<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeletesOnManyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('progrestions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tutorials', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('annonces', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('curriculums', function (Blueprint $table) {
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
        Schema::table('questions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('progrestions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tutorials', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
