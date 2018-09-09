<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Team::class, function (Faker $faker) {
    $name = $faker->unique()->name;
    return [
      'name'    => $name,
      'slug'    => str_slug($name),
      'user_id' => \App\Models\User::inRandomOrder()->first()->id,
    ];
});
