<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(DavideCasiraghi\LaravelCards\Models\Card::class, function (Faker $faker) {
    return [
        'heading' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'body' => $faker->paragraph,
        'image' => 'testImage.jpg',
        'image_alt' => $faker->sentence($nbWords = 5, $variableNbWords = true),
    ];
});