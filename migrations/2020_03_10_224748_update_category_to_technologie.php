<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryToTechnologie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('categories', 'technologies');

        Schema::table('tutorials', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->renameColumn('category_id', 'technologie_id');
            $table->foreign('technologie_id')
                ->references('id')
                ->on('technologies')
                ->onDelete('cascade');
        });

        Schema::table('lives', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->renameColumn('category_id', 'technologie_id');
            $table->foreign('technologie_id')
                ->references('id')
                ->on('technologies')
                ->onDelete('cascade');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->renameColumn('category_id', 'technologie_id');
            $table->foreign('technologie_id')
                ->references('id')
                ->on('technologies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('technologies', 'categories');

        Schema::table('categories', function (Blueprint $table) {
            //
        });

        Schema::table('tutorials', function (Blueprint $table) {
            $table->renameColumn('technologie_id', 'category_id');
        });

        Schema::table('lives', function (Blueprint $table) {
            $table->renameColumn('technologie_id', 'category_id');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('technologie_id', 'category_id');
        });
    }
}
