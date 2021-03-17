<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'department_id' => \App\Models\Department::inRandomOrder()->first()->id,
        'start_date' => $faker->date,
        'deadline' => $faker->unique()->numberBetween(1, 20),
        'budget' => $faker->unique()->numberBetween(1, 6000),
        'requirements' => 'requirements1s,requirements2,requirements3',
        'resources' => 'aaa,aaaa'
    ];
});
