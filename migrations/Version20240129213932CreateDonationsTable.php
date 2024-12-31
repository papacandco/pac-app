<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240129213932CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('donations', function (SQLGenerator $table) {
            $table->addBigIncrement('id');
            $table->addString('amount');
            $table->addString('provider');
            $table->addString('status', ['default' => false]);
            $table->addString('ip');
            $table->addString('user_id');
            $table->addString('transaction_id', ['nullable' => true]);
            $table->addText('provider_data');
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
        $this->dropIfExists('donations');
    }
}
