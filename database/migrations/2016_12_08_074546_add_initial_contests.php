<?php

use App\Models\Contest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// adds some contests and results. This is included in migration because it is just a project for learning and
// we need some initial data after deployment
class AddInitialContests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Contest::create([
            'name' => 'RobLeg 2014',
            'isRegistrationFinished' => true,
        ]);
        Contest::create([
            'name' => 'RobLeg 2015',
            'isRegistrationFinished' => true,
        ]);
        Contest::create([
            'name' => 'RobLeg 2016',
            'isRegistrationFinished' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('contests')->delete();
    }
}
