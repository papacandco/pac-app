<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateActionTracker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_trackers', function (Blueprint $table) {
            $table->renameColumn('client', 'user_agent');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('country_flag')->nullable();
            $table->string('url')->nullable();
            $table->integer('view')->default(1);
            $table->dropColumn('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_trackers', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('country_flag');
            $table->dropColumn('url');
            $table->dropColumn('view');
            $table->text('location');
            $table->renameColumn('user_agent', 'client');
        });
    }
}
