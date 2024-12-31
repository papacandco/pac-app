<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20241026210825CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('purchases', function (SQLGenerator $table) {
            $table->addBigIncrement('id');
            $table->addInteger('price');
            $table->addInteger('fee', ['default' => 0]);
            $table->addInteger('purchascolumn: eable_id');
            $table->addString('purchaseable_type');
            $table->addInteger('user_id', ['nullable' => true]);
            $table->addForeign('user_id', [
                'references' => 'id',
                'table' => 'users',
                'on' => 'delete set null',
            ]);
            $table->addJson('extras', ['nullable' => true]);
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
        $this->dropIfExists('purchases');
    }
}
