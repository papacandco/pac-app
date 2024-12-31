<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20240618141613CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('questions', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('title');
            $table->addString('slug', ['unique' => true]);
            $table->addText('content');
            $table->addInteger('user_id');
            $table->addInteger('technology_id', ['nullable' => true]);
            $table->addString('forumable_id');
            $table->addString('forumable_type');
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
        $this->dropIfExists('questions');
    }
}
