<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240725113305CreateProgrestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('progrestions', function (SQLGenerator $table) {
            $table->addBigIncrement('id');
            $table->addInteger('user_id');
            $table->addInteger('timespent', ['default' => 0]);
            $table->addBoolean('ended', ['default' => false]);
            $table->addInteger('tutorial_id');
            $table->addInteger('curriculum_id');
            $table->addDateTime('started_at');
            $table->addDateTime('ended_at', ['nullable' => true]);
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
        $this->dropIfExists('progrestions');
    }
}
