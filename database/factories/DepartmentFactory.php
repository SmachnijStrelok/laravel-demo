<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Components\Department\Entities\Department;
use App\Http\Components\User\Entities\User;
use App\Http\Components\User\SignUp\Services\PasswordHasher;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Department::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 month', '-1 days');
    return [
        'name' => $faker->sentence(rand(2, 7)),
        'description' => $faker->realText(rand(100, 300)),
        'logo_id' => null,
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
