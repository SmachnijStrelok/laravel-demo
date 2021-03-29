<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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

$factory->define(User::class, function (Faker $faker) {
    $container = app();
    $hasher = $container->make(PasswordHasher::class);
    return [
        'surname' => $faker->lastName,
        'name' => $faker->name,
        'patronymic' => $faker->word(),
        'mobile_phone' => rand(80000000000, 89999999999),
        'email' => $faker->email,
        'role' => User::ROLE_USER,
        'state' => User::STATE_ACTIVE,
        'password_hash' => $hasher->hash('password')
    ];
});
