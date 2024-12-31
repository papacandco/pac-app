<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240308214702CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('sections', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('title');
            $table->addString('description', ['size' => 500]);
            $table->addInteger('`order`', ['default' => 0]);
            $table->addInteger('curriculum_id', ['nullable' => true]);
            $table->addForeign('curriculum_id', [
                'references' => 'id',
                'table' => 'curriculums',
                'on' => 'delete set null',
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
        $this->dropIfExists('sections');
    }
}
