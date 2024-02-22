<?php

namespace Workbench\Database\Factories;

use Workbench\App\Models\CustomAction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Workbench\App\Models\CustomAction
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
final class CustomActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = CustomAction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->paragraph(),
        ];
    }
}
