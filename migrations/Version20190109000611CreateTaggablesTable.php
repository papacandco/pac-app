<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20190109000611CreateTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('taggables', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addInteger('tag_id');
            $table->morphs('taggable');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->alter('taggables', function (SQLGenerator $table) {
            $table->dropForeign('tag_id');
        });

        $this->dropIfExists('taggables');
    }
}
