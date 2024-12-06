<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('long_description');
            $table->dropColumn('video');
            $table->dropColumn('duration');
            $table->dropColumn('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('long_description')->nullable();
            $table->string('video')->nullable();
            $table->string('duration')->nullable();
            $table->tinyInteger('level')->nullable();
            $table->tinyInteger('type')->default(1);
        });
    }
}
