<?php

use Bow\Database\Migration\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('countries', function (SQLGenerator $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('dial_code');
            $table->string('currency');
            $table->string('flag', 500);
            $table->timestamps();
            $table->string('dial_code')->nullable()->change();
            $table->string('currency')->nullable()->change();
            $table->string('flag', 500)->nullable()->change();
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
