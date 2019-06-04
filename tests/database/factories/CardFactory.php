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
        'heading:en' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'title:en' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'body:en' => $faker->paragraph,
        'title:en' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'button_text:en' => $faker->sentence($nbWords = 1, $variableNbWords = true),
        'image_file_name' => 'testImage.jpg',
        'img_alignment' => '1',
        'img_col_size' => '200px',
        'bkg_color' => '#FF00FF',
        'text_color' => '#AA55AA',
        'button_url' => 'https://www.google.it',
        'button_color' => '#FF00BB',
        'button_corners' => '2',
        'button_icon' => '2',
        'container_wrap' => false,
    ];
});
