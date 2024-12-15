<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('technology_id');
            $table->foreign('technology_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->dropForeign(['technologie_id']);
            $table->dropColumn('technologie_id');
            $table->morphs('forumable');
            $table->timestamps();
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
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('questions');
    }
}
