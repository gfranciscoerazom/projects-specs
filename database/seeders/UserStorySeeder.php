<?php

namespace Database\Seeders;

use App\Models\UserStory;
use Illuminate\Database\Seeder;

class UserStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserStory::factory(5)->create();
    }
}
