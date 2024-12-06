<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishedAtTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable()->default(null)->before('created_at');
            $table->boolean('published')->default(false)->before('published_at');
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable()->default(null)->before('created_at');
            $table->boolean('published')->default(false)->before('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->dropColumn('published_at');
            $table->dropColumn('published');
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropColumn('published_at');
            $table->dropColumn('published');
        });
    }
}
