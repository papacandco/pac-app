<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20190604195032CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('bookmarks', function (SQLGenerator $table) {
            $table->addIncrement('id');
            $table->addString('bookmarkable_id');
            $table->addString('bookmarkable_type');
            $table->addInteger('user_id', ['unsigned' => true]);
            $table->addForeign('user_id', [
                'references' => 'id',
                'table' => 'users',
                'on' => 'on delete',
            ]);
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
        $this->alter('bookmarks', function (SQLGenerator $table) {
            $table->dropForeign('user_id');
        });
        $this->dropIfExists('bookmarks');
    }
}
