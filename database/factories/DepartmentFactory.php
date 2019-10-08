<?php

use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(7),
        'description' => $faker->text(100),
        'logo' => $faker->image('logo', 150)
    ];
});
