<?php

namespace Motor\CMS\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Motor\CMS\Models\Navigation;

class NavigationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Navigation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
