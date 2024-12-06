<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLiveToChallenge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('lives', 'challenges');
        Schema::rename('live_invites', 'challenge_invites');

        Schema::table('challenge_invites', function (Blueprint $table) {
            $table->renameColumn('live_id', 'challenge_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challenge_invites', function (Blueprint $table) {
            $table->renameColumn('challenge_id', 'live_id');
        });
        Schema::rename('challenges', 'lives');
        Schema::rename('challenge_invites', 'live_invites');
    }
}
