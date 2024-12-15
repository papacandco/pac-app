<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20190106161058CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('authors', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('pseudo');
            $table->addString('email');
            $table->addString('name');
            $table->addString('description');
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
        $this->dropIfExists('authors');
    }
}
