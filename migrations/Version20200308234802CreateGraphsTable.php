<?php

use Bow\Database\Migration\Migration;

class CreateGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('graphs', function (SQLGenerator $table) {
            $table->increments('id');
            $table->morphs('graph');
            $table->unsignedInteger('section_id');
            $table->integer('order')->default(1);
            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->alter('graphs', function (SQLGenerator $table) {
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });
        $this->dropIfExists('graphs');
    }
}
