<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Draft::class, function (Faker $faker) {
    return [
        'set_id' => factory(\App\Set::class),
        'code' => $faker->asciify('*****')
    ];
});

$factory->define(\App\Set::class, function (Faker $faker) {
    return [
        'name' => $faker->text(5),
        'code' => $faker->asciify('***')
    ];
});

$factory->define(\App\Card::class, function (Faker $faker) {
    return [
        'set_id' => factory(\App\Set::class),
        'name' => $faker->lastName,
        'text' => $faker->text,
        'small_image' => '',
        'normal_image' => '',
        'large_image' => '',
        'colors' => '',
        'cmc' => '',
        'type_line' => '',
        'rarity' => '',
    ];
});
$factory->define(\App\Player::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});


