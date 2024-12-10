<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceOnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->integer('price')->default(0);
            $table->boolean('one_time')->default(false);
        });
        Schema::table('tutorials', function (Blueprint $table) {
            $table->integer('price')->default(0);
            $table->boolean('one_time')->default(false);
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->integer('price')->default(0);
            $table->boolean('one_time')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
