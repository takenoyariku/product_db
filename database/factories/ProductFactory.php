<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->word,
        'price' => $faker->randomDigit,
        'stock' => $faker->randomDigit,
        'img_path' => $faker->word,
        'comment' => $faker->realText
    ];
});
