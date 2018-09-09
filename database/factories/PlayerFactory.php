<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Player::class, function (Faker $faker) {
    return [
      'first_name'    => $faker->unique()->name,
      'last_name'    => $faker->unique()->name,
      'team_id' => \App\Models\Team::inRandomOrder()->first()->id,
    ];
});
