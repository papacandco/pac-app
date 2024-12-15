<?php

use Bow\Database\Migration\Migration;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('donations', function (SQLGenerator $table) {
            $table->bigIncrements('id');
            $table->string('order_id')->unique();
            $table->string('amount');
            $table->string('notif_token');
            $table->string('pay_token');
            $table->string('provider');
            $table->string('transaction_id')->nullable();
            $table->ipAddress('ip');
            $table->morphs('user');
            $table->string('status')->default('pending');
            $table->renameColumn('order_id', 'transaction')->unique();
            $table->dropColumn('notif_token');
            $table->dropColumn('pay_token');
            $table->dropColumn('provider');
            $table->text('provider_data')->after('status');
            $table->dropColumn('transaction_id');
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
        $this->dropIfExists('donations');
    }
}
