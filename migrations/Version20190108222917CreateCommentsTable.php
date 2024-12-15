<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20190108222917CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('comments', function (SQLGenerator $table) {
            $table->addBigIncrement('id');
            $table->addText('content');
            $table->addString('commentable_id');
            $table->addString('commentable_type');
            $table->addString('user_id');
            $table->addString('user_type');
            $table->addInteger('parent_id', ['default' => 0]);
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
        $this->dropIfExists('comments');
    }
}
