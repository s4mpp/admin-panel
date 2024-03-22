<?php

namespace Workbench\Database\Factories;

use Workbench\App\Models\Report;
use Workbench\App\Models\Repeater;
use Workbench\App\Models\BasicItem;
use Workbench\App\Models\ChildRepeater;
use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Select;

/**
 * @template TModel of \Workbench\App\BasicItem
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class SelectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Select::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
			'array' => fake()->randomDigitNotZero(),
			'array_multidimensional' => fake()->randomDigitNotZero(),
			'array_multidimensional_with_key' => fake()->randomDigitNotZero(),
			'array_multidimensional_with_value_as_key' => fake()->randomDigitNotZero(),
			'array_with_callback' => fake()->randomDigitNotZero(),
			'enum' => fake()->randomDigitNotZero(),
			'enum_with_callback' => fake()->randomDigitNotZero(),
			'collection' => fake()->randomDigitNotZero(),
			'collection_multidimensional' => fake()->randomDigitNotZero(),
			'collection_multidimensional_with_key' => fake()->randomDigitNotZero(),
			'collection_multidimensional_with_value_as_key' => fake()->randomDigitNotZero(),
			'eloquent_collection' => fake()->randomDigitNotZero(),
			'eloquent_collection_with_key' => fake()->randomDigitNotZero(),
			'eloquent_collection_with_value_as_key' => fake()->randomDigitNotZero(),
        ];
    }
}
