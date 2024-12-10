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
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->dateTime('published_at')->nullable();
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
