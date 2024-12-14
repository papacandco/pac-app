<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('categories', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('title');
            $table->addString('slug', ['unique' => true]);
            $table->addString('color', ['size' => 1, 'nullable' => true]);
            $table->addTinyInteger('type', ['default' => 1]);
            $table->addTinyInteger('with_forum', ['default' => 1]);
            $table->addString('description');
            $table->addText('long_description', ['nullable' => true]);
            $table->addString('video', ['nullable' => true]);
            $table->addString('duration', ['nullable' => true]);
            $table->addTinyInteger('level', ['nullable' => true]);
            $table->addString('cover', ['nullable' => true]);
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
        $this->dropIfExists('categories');
    }
}
