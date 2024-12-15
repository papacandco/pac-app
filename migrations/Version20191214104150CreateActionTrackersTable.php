<?php

use Bow\Database\Migration\Migration;

class CreateActionTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('action_trackers', function (SQLGenerator $table) {
            $table->increments('id');
            $table->text('location');
            $table->morphs('trackable');
            $table->string('referer');
            $table->string('client');
            $table->ipAddress('ip');
            $table->timestamps();
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
