<?php

$factory->define(Motor\CMS\Models\Navigation::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Motor\CMS\Models\Page::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});
