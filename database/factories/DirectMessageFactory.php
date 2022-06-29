<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\DirectMessage::class, function (Faker $faker) {
    return [
        //
        'message' => $faker->paragraph,
        'user_id' => 1,
        'room_id' => 3,

    ];
});
