<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\SubConstructor::class, function (Faker $faker) {
    $tenantIds = \App\Models\Tenant::all()->pluck('id')->toArray();
    return [
        'name' => $faker->name,
        'uen' => $faker->randomNumber(),
        'tenancy_start_date' => $faker->dateTimeBetween('now', '+1 years'),
        'tenancy_end_date' => $faker->dateTimeBetween('now', '+10 years'),
        'tenant_id' => array_rand($tenantIds)
    ];
});