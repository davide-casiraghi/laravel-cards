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

$factory->define(DavideCasiraghi\LaravelCards\Models\Post::class, function (Faker $faker) {
    
    return [
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'text' => $faker->paragraph,
    ];
});
