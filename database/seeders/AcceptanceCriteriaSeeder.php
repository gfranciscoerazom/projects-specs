<?php

namespace Database\Seeders;

use App\Models\AcceptanceCriteria;
use Illuminate\Database\Seeder;

class AcceptanceCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcceptanceCriteria::factory(5)->create();
    }
}
