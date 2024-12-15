<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // L'idee ici c'est d'avoir une historique de fichier ajouter supprimer dans le systeme
        $this->create('materials', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('description');
            $table->addString('path');
            $table->addString('filename');
            $table->addString('filesize');
            $table->addString('mimetype');
            $table->addString('extension');
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
        $this->dropIfExists('materials');
    }
}
