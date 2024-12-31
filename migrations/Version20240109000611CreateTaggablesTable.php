<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240109000611CreateTaggablesTable extends Migration
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
            $table->addInteger('taggable_id');
            $table->addString('taggable_type');
            $table->addForeign('tag_id', [
                'references' => 'id',
                'table' => 'tags',
                'on' => 'delete cascade'
            ]);
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
