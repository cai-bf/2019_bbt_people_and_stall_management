<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Schedule::class, function (Faker $faker) {
    return [
        'user_id'=>mt_rand(1930,2500),
        'week'=>1,
        'day'=>2,
        'class'=>mt_rand(1,8),
    ];
});
