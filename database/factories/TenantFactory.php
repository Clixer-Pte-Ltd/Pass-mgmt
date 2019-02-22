<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Tenant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'uen' => $faker->randomNumber(),
        'tenancy_start_date' => $faker->dateTimeBetween('now', '+1 years'),
        'tenancy_end_date' => $faker->dateTimeBetween('now', '+10 years'),
    ];
});
