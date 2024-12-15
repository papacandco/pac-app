<?php

use Bow\Database\Migration\Migration;

class CreateProgrestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('progrestions', function (SQLGenerator $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('timespent')->default(0);
            $table->boolean('ended')->default(false);
            $table->integer('tutorial_id');
            $table->integer('curriculum_id');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
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
        $this->dropIfExists('progrestions');
    }
}
