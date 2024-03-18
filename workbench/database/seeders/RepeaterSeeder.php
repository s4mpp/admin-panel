<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use Workbench\App\Models\ChildRepeater;
use Workbench\Database\Factories\ChildRepeaterFactory;
use Workbench\Database\Factories\RepeaterFactory;

final class RepeaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RepeaterFactory::new()
            ->has(ChildRepeaterFactory::new()->count(10))
            ->create();
    }
}
