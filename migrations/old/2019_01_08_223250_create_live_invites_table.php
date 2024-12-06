<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('live_id');
            $table->unsignedInteger('user_id');
            $table->tinyInteger('status')->default(0);
            $table->string('access_token');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('live_id')->references('id')->on('lives')->onDelete('cascade');
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
        Schema::table('live_invites', function (Blueprint $table) {
            $table->dropForeign(['live_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('live_guests');
    }
}
