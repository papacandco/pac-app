<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240611122947CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('countries', function (SQLGenerator $table) {
            $table->addIntegerPrimary('id');
            $table->addString('name');
            $table->addString('code');
            $table->addString('dial_code', ['nullable' => true]);
            $table->addString('currency', ['nullable' => true]);
            $table->addString('flag', ['nullable' => true, 'size' => 500]);
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
        $this->dropIfExists('countries');
    }
}
