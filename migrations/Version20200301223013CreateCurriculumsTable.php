<?php

use Bow\Database\Migration\Migration;

class CreateCurriculumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('curriculums', function (SQLGenerator $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('color', 7)->nullable();
            $table->string('description');
            $table->text('long_description')->nullable();
            $table->string('video')->nullable();
            $table->string('duration')->nullable();
            $table->tinyInteger('level')->default(1)->nullable();
            $table->string('cover')->nullable();
            $table->integer('order')->default(0);
            $table->tinyInteger('published')->before('created_at')->default(0);
            $table->unsignedInteger('technologie_id')->before('created_at');
            $table->foreign('technologie_id')
            ->references('id')
                ->on('technologies')
                ->onDelete('cascade');
            $table->tinyInteger('with_forum')->default(0);
            $table->string('duration_type')->after('duration')->default('Heures');
            $table->integer('price')->default(0);
            $table->boolean('one_time')->default(false);
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
        $this->dropIfExists('curriculums');
    }
}
