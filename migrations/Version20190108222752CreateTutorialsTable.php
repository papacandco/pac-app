<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('color', 7)->nullable();
            $table->text('content')->nullable();
            $table->string('description');
            $table->string('video')->nullable();
            $table->string('cover')->nullable();
            $table->string('duration')->nullable();
            $table->integer('level')->default(1);
            $table->string('request_by')->nullable();
            $table->string('repository')->nullable();
            $table->string('source')->nullable();
            $table->string('pdf')->nullable();
            $table->tinyInteger('published')->default(0);
            $table->unsignedInteger('technology_id');
            $table->foreign('technology_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->unsignedInteger('author_id')->nullable()->before('created_at');
            $table->foreign('author_id')
                ->references('id')
                ->on('authors');
            $table->dateTime('published_at')->nullable();
            $table->unsignedInteger('graph_id')->nullable();
            $table->foreign('graph_id')
                ->references('id')
                ->on('graphs')
                ->onDelete('set null');
            $table->string('duration_type')->after('duration')->default('Munites');
            $table->dateTime('published_at')->nullable()->default(null)->before('created_at');
            $table->boolean('published')->default(false)->before('published_at');
            $table->integer('price')->default(0);
            $table->boolean('one_time')->default(false);
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
        Schema::table('tutorials', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('tutorials');
    }
}
