<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\CustomAction;

/**
 * @template TModel of \Workbench\App\Models\CustomAction
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class CustomActionFactory extends Factory
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
            'description' => fake()->paragraph()
        ];
    }
}
