<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // L'idee ici c'est d'avoir une historique de fichier ajouter supprimer dans le systeme
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('url');
            $table->string('path');
            $table->string('filename');
            $table->string('filesize');
            $table->string('mimetype');
            $table->morphs('target');
            $table->dropColumn('target_id');
            $table->dropColumn('target_type');
            $table->dropColumn('url');
            $table->string('extension')->after('mimetype');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
