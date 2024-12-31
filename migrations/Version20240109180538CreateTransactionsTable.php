<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240109180538CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('transactions', function (SQLGenerator $table) {
            $table->addUuidPrimary('id');
            $table->addFloat('amount');
            $table->addEnum('status', ['default' => 'pending', 'size' => ['pending', 'success', 'failed']]);
            $table->addString('provider');
            $table->addString('type');
            $table->addString('target_id');
            $table->addString('target_type');
            $table->addString('user_id');
            $table->addString('user_type');
            $table->addJson('extras');
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
        $this->dropIfExists('transactions');
    }
}
