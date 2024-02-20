<?php

namespace Database\Seeders;

use Workbench\App\Models\User;
use Illuminate\Database\Seeder;
use Workbench\Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(100)->create();
    }
}
