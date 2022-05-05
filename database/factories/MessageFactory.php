<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'message' => $faker->paragraph,
        'user_id' => 2,
        'channel_id' => 2,
    ];
});
