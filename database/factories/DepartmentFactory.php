<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
