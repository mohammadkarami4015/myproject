<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Letter;
use Faker\Generator as Faker;

$factory->define(Letter::class, function (Faker $faker) {
    return [
        'title'=>$faker->title,
        'details'=>$faker->sentence,
        'user_id'=>factory(\App\User::class)->create()->id,
    ];
});
