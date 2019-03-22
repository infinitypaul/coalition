<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->name,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'quantity' => $faker->numberBetween(1, 9999),
        'price_per_item' => $faker->numberBetween(99, 99999999999999999),
    ];
});
