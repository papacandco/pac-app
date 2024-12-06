<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description', 300);
            $table->text('content');
            $table->string('cover', 200)->nullable();
            $table->string('source', 200)->nullable();
            $table->unsignedInteger('author_id');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('premium')->default(0);
            $table->integer('duration')->default(5);
            $table->foreign('author_id')
                ->on('authors')
                ->references('id')
                ->onUpdate('cascade');
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
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        Schema::dropIfExists('podcasts');
    }
}
