<?php

$factory->define(Motor\CMS\Models\Navigation::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Motor\CMS\Models\Page::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});
