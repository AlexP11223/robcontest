<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Models\Role;

class InsertDefaultAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = new User;
        $user->name = 'admin';
        $user->email = 'alex.pantec@gmail.com';
        $user->password = \Hash::make('pass123');

        $user->save();

        $user->addRole(Role::whereName('admin')->first());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->delete();
    }
}
