<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sumo_games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_index')->unsigned()->index();
            $table->integer('round_index')->unsigned()->index();
            $table->integer('team1_id')->unsigned()->index();
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->integer('team2_id')->nullable()->unsigned()->index();
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
            $table->integer('winner_team_id')->nullable()->unsigned()->index();
            $table->foreign('winner_team_id')->references('id')->on('teams')->onDelete('cascade');
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
        Schema::dropIfExists('sumo_games');
    }
}
