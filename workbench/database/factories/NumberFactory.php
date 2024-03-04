<?php

namespace Workbench\Database\Factories;

use Workbench\App\Models\Number;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Workbench\App\Number
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class NumberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Number::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'basic_decimal' => fake()->randomFloat(2, 0, 100),
            'basic_decimal_2' => fake()->randomFloat(2, 0, 100),
            'basic_decimal_min' => fake()->randomFloat(2, 0, 100),
            'basic_decimal_max' => fake()->randomFloat(2, 0, 100),
            'basic_integer' => fake()->randomDigitNotZero(),
            'basic_integer_2' => fake()->randomDigitNotZero(),
            'basic_integer_min' => fake()->randomDigitNotZero(),
            'basic_integer_max' => fake()->randomDigitNotZero(),
        ];
    }
}
