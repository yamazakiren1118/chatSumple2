<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Channel;

$factory->define(App\Channel::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->unique()->word,
    ];
});
