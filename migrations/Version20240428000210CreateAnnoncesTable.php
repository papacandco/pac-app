<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240428000210CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('annonces', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('type');
            $table->addString('message');
            $table->addString('link');
            $table->addTinyInteger('online');
            $table->addString('cover', ['nullable' => true]);
            $table->addString('color', ['default' => '#151515']);
            $table->addInteger('click', ['default' => 0]);
            $table->addDateTime('started_at', ['nullable' => true]);
            $table->addDateTime('ended_at', ['nullable' => true]);
            $table->addString('bg_color', ['default' => '#181818']);
            $table->addString('font_color', ['default' => '#FFF']);
            $table->addString('link_color', ['default' => '#0747A6']);
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
        $this->dropIfExists('annonces');
    }
}
