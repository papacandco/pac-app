<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240131152656CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('notifications', function (SQLGenerator $table) {
            $table->addUuid('id', ['primary' => true]);
            $table->addString('type');
            $table->addString('notifiable_id');
            $table->addString('notifiable_type');
            $table->addText('data');
            $table->addTimestamp('read_at', ['nullable' => true]);
            $table->addtimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->dropIfExists('notifications');
    }
}
