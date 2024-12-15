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
            $table->boolean('theme')->default(0)->before('created_at');
            $table->dateTime('logged_at')->nullable()->before('created_at');
            $table->string('country')->nullable();
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
