<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Contest::class, function (Faker\Generator $faker) {
    return [
        'name' => 'RobLeg ' . $faker->unique->numberBetween(1970, 2000),
        'isRegistrationFinished' => false,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TeamMember::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'dob' => $faker->dateTimeBetween('-11 years', '-8 years'),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Robots ' . $faker->word,
        'teacher_first_name' => $faker->firstName,
        'teacher_last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'school' => $faker->word . ' school',
        'sumo' => true,
        'obstacles' => true,
        'contest_id' => factory(\App\Models\Contest::class)->create()->id,
    ];
});
