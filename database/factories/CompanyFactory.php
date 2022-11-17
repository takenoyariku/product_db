<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'company_name' => $faker->word,
        'street_address' => $faker->word,
        'representative_name' => $faker->word,
    ];
});
