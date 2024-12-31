<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240809140113CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('podcasts', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('title');
            $table->addString('description', ['size' => 300]);
            $table->addText('content');
            $table->addString('cover', ['size' => 200, 'nullable' => true]);
            $table->addString('source', ['size' => 200, 'nullable' => true]);
            $table->addInteger('author_id', ['nullable' => true]);
            $table->addTinyInteger('status', ['default' => 0]);
            $table->addTinyInteger('premium', ['default' => 0]);
            $table->addInteger('duration', ['default' => 5]);
            $table->addForeign('author_id', [
                'table' => 'authors',
                'references' => 'id',
                'on' => 'delete set null',
            ]);
            $table->addString('duration_type', ['default' => 'h']);
            $table->addDateTime('published_at', ['nullable' => true, 'default' => null]);
            $table->addBoolean('published', ['default' => false]);
            $table->addInteger('price', ['default' => 0]);
            $table->addBoolean('one_time', ['default' => false]);
            $table->addTimestamps();
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
            $table->dropForeign('author_id');
        });

        $this->dropIfExists('podcasts');
    }
}
