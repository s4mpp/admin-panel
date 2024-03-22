<?php

namespace Workbench\Database\Factories;

use Workbench\App\Models\Report;
use Workbench\App\Models\Repeater;
use Workbench\App\Models\BasicItem;
use Workbench\App\Models\ChildRepeater;
use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Date;

/**
 * @template TModel of \Workbench\App\BasicItem
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class DateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Date::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
			
			'basic_date' => fake()->date(),
			'date_no_cast' => fake()->date(),
			'basic_datetime' => fake()->dateTime(),
			'datetime_no_cast' => fake()->dateTime(),
        ];
    }
}
