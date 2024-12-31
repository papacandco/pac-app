<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240119161127CreateConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
       $this->create('configurations', function (SQLGenerator $table) {
            $table->addString('name');
            $table->addString('username');
            $table->addString('email');
            $table->addString('password');
            $table->addTinyInteger('mode', ['default' => 0]);
            $table->addTinyInteger('alert', ['default' => 0]);
            $table->addString('about_video', ['nullable' => true]);
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
       $this->dropIfExists('configurations');
    }
}
