<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nfe;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Nfe::class, function (Faker $faker) {
    return [
        'access_key' => Str::random(45),
        'valor' => $faker->randomFloat(2,1, 30000),
    ];
});
