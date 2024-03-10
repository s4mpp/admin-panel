<?php

namespace Workbench\Database\Factories;

use Workbench\App\Models\BasicItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Workbench\App\BasicItem
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class BasicItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = BasicItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'title_uppercase' => fake()->word(),
            'title_with_default_text' => fake()->word(),
            'basic_text' => fake()->text(),
            'basic_email' => fake()->email(),
            'basic_textarea' => fake()->text(),
            'long_textarea' => fake()->text(),
        ];
    }
}
