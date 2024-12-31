<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20241214104150CreateActionTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('action_trackers', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addText('location');
            $table->addString('trackable_id');
            $table->addString('trackable_type');
            $table->addString('referer');
            $table->addString('client');
            $table->addString('ip');
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
        $this->dropIfExists('action_trackers');
    }
}
