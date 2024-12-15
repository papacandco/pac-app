<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20141012000000CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('users', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('name');
            $table->addString('email', ['unique' => true]);
            $table->addString('sexe', ['nullable' => true]);
            $table->addString('pseudo', ['nullable' => true, 'unique' => true]);
            $table->addTimestamp('email_verified_at', ['nullable' => true]);
            $table->addString('password', ['nullable' => true]);
            $table->addString('avatar', ['nullable' => true]);
            $table->addString('provider_id', ['nullable' => true]);
            $table->addString('provider_type', ['nullable' => true]);
            $table->addBoolean('theme', ['default' => 0]);
            $table->addDateTime('logged_at', ['nullable' => true]);
            $table->addString('country', ['nullable' => true]);
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
        $this->dropIfExists('users');
    }
}
