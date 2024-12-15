<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20190429111157CreateNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('newsletters', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('email');
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
        $this->dropIfExists('newletters');
    }
}
