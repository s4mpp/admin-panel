<?php

namespace Workbench\Database\Factories;

use S4mpp\AdminPanel\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Workbench\App\Models\Product
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->word(),
            'value' => fake()->sentence()
        ];
    }
}
