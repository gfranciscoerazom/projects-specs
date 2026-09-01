<?php

namespace Database\Seeders;

use App\Models\PlanTask;
use Illuminate\Database\Seeder;

class PlanTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanTask::factory(5)->create();
    }
}
