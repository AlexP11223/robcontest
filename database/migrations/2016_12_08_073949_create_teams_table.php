<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('teacher_first_name');
            $table->string('teacher_last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('school')->nullable();
            $table->integer('contest_id')->unsigned()->index();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
            $table->boolean('sumo');
            $table->boolean('obstacles');
            $table->boolean('approved')->nullable();
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->timestamps();
        });

        Schema::create(
            'teams_team_members',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('team_id')->unsigned()->index();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
                $table->integer('team_member_id')->unsigned()->index();
                $table->foreign('team_member_id')->references('id')->on('team_members')->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams_team_members');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_members');
    }
}
