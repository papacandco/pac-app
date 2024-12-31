<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240308214802CreateGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('graphs', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('graph_id');
            $table->addString('graph_type');
            $table->addInteger('section_id', ['nullable' => true]);
            $table->addInteger('order', ['default' => 1]);
            $table->addForeign('section_id', [
                'references' => 'id',
                'table' => 'sections',
                'on' => 'delete set null',
            ]);
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
        $this->alter('graphs', function (SQLGenerator $table) {
            $table->dropForeign('section_id');
        });
        $this->dropIfExists('graphs');
    }
}
