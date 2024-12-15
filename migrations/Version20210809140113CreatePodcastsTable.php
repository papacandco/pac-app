<?php

use Bow\Database\Migration\Migration;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('podcasts', function (SQLGenerator $table) {
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
            $table->string('duration_type')->after('duration')->default('Heures');
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
    public function rollback(): void
    {
        $this->alter('podcasts', function (SQLGenerator $table) {
            $table->dropForeign(['author_id']);
        });

        $this->dropIfExists('podcasts');
    }
}
