<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInTutorialAndCurriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tutorials', function (Blueprint $table) {
            $table->unsignedInteger('graph_id')->nullable();
            $table->foreign('graph_id')
                ->references('id')
                ->on('graphs')
                ->onDelete('set null');
        });

        Schema::table('curriculums', function (Blueprint $table) {
            $table->integer('order')->default(0);
            $table->tinyInteger('published')->before('created_at')->default(0);
            $table->unsignedInteger('technologie_id')->before('created_at');
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
        Schema::table('tutorials', function (Blueprint $table) {
            $table->dropForeign(['graph_id']);
            $table->dropColumn('graph_id');
        });

        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropForeign(['technologie_id']);
            $table->dropColumn('published');
            $table->dropColumn('technologie_id');
        });
    }
}
