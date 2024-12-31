<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240301223013CreateCurriculumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('curriculums', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('title');
            $table->addString('slug', ['unique' => true]);
            $table->addString('color', ['default' => 0, 'size' => 7]);
            $table->addString('description');
            $table->addText('long_description');
            $table->addString('video', ['default' => 0]);
            $table->addString('duration', ['default' => 0]);
            $table->addTinyInteger('level', ['default' => 1, 'nullable' => true]);
            $table->addString('cover', ['nullable' => true]);
            $table->addInteger('order', ['default' => 0]);
            $table->addTinyInteger('published', ['default' => 0]);
            $table->addInteger('technology_id', ['nullable' => true]);
            $table->addForeign('technology_id', [
                'references' => 'id',
                'table' => 'technologies',
                'on' => 'delete set null',
            ]);
            $table->addTinyInteger('with_forum', ['default' => 0]);
            $table->addString('duration_type', ['default' => 'h']);
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
        $this->dropIfExists('curriculums');
    }
}
