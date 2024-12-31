<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240308222752CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('tutorials', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('title');
            $table->addString('slug', ['unique' => true]);
            $table->addString('color', ['nullable' => true]);
            $table->addText('content', ['nullable' => true]);
            $table->addString('description');
            $table->addString('video', ['nullable' => true]);
            $table->addString('cover', ['nullable' => true]);
            $table->addString('duration', ['nullable' => true]);
            $table->addInteger('level', ['default' => 1]);
            $table->addString('request_by', ['nullable' => true]);
            $table->addString('repository', ['nullable' => true]);
            $table->addString('source', ['nullable' => true]);
            $table->addString('pdf', ['nullable' => true]);
            $table->addTinyInteger('published', ['default' => 0]);
            $table->addInteger('technology_id');
            $table->addForeign('technology_id', [
                'references' => 'id',
                'table' => 'technologies',
                'on' => 'delete cascade',
            ]);
            $table->addInteger('author_id', ['nullable' => true]);
            $table->addForeign('author_id', [
                'references' => 'id',
                'table' => 'authors',
                'on' => 'delete set null'
            ]);
            $table->addDateTime('published_at', ['nullable' => true, 'default' => null]);
            $table->addInteger('graph_id', ['nullable' => true]);
            $table->addForeign('graph_id', [
                'references' => 'id',
                'table' => 'graphs',
                'on' => 'delete set null'
            ]);
            $table->addString('duration_type', ['default' => 'm']);
            $table->addInteger('price', ['default' => true]);
            $table->addBoolean('one_time', ['default' => false]);
            $table->addBoolean('premium', ['default' => false]);
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
        $this->alter('tutorials', function (SQLGenerator $table) {
            $table->dropForeign('category_id');
        });

        $this->dropIfExists('tutorials');
    }
}
