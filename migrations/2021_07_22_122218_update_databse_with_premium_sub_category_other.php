<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDatabseWithPremiumSubCategoryOther extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->tinyInteger('premium')->default(0);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('premium')->default(0);
        });
        Schema::table('challenges', function (Blueprint $table) {
            $table->tinyInteger('premium')->default(0);
        });
        Schema::table('tutorials', function (Blueprint $table) {
            $table->tinyInteger('premium')->default(0);
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('curriculum_id')->after('user_id')->default(0);
            $table->dropMorphs('forumable');
        });
        Schema::table('technologies', function (Blueprint $table) {
            $table->integer('parent_id')->default(0);
        });
        Schema::table('taggables', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
        });
        Schema::dropIfExists('tags');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropColumn('premium');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('premium');
        });
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropColumn('premium');
        });
        Schema::table('tutorials', function (Blueprint $table) {
            $table->dropColumn('premium');
        });
        Schema::table('technologies', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
