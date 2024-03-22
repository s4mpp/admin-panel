<?php

namespace Workbench\Database\Factories;

use Workbench\App\Models\Report;
use Workbench\App\Models\Repeater;
use Workbench\App\Models\BasicItem;
use Workbench\App\Models\ChildRepeater;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Workbench\App\BasicItem
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Report::class;

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
