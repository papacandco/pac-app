<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('identifier')->unique();
            $table->string('title');
            $table->string('icon_url')->nullable()->default(null);
            $table->string('description');
            $table->float('price');
            $table->json('options');
            $table->integer('order');
            $table->boolean('published')->default(false);
            $table->datetime('published_at')->nullable()->default(null);
            $table->increments('id')->change();
            $table->string('product_id')->after('id')->size(200)->unique();
            $table->string('interval')->default('month');
            $table->integer('reduction')->nullable();
            $table->string('reduction_type')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}