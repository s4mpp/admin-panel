<?php

namespace Workbench\Database\Factories;

use Workbench\App\Models\Filter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Workbench\App\Filter
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class FilterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Filter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
        ];
    }
}
