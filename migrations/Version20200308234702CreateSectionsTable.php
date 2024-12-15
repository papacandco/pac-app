<?php

use Bow\Database\Migration\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('sections', function (SQLGenerator $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description', 500);
            $table->integer('order')->default(0);
            $table->unsignedInteger('curriculum_id');
            $table->foreign('curriculum_id')
                ->references('id')
                ->on('curriculums')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->dropIfExists('sections');
    }
}
