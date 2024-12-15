<?php

use Bow\Database\Migration\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('transactions', function (SQLGenerator $table) {
            $table->uuid('id')->primary();
            $table->float('amount');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('provider');
            $table->string('type');
            $table->morphs('target');
            $table->morphs('user');
            $table->json('extras');
            $table->softDeletes();
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
        $this->dropIfExists('transactions');
    }
}
