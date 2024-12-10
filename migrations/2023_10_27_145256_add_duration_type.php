<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->string('duration_type')->after('duration')->default('Heures');
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->string('duration_type')->after('duration')->default('Minutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropColumn('duration_type');
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropColumn('duration_type');
        });
    }
}
