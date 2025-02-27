<?php

namespace Database\Seeders;

use App\Modules\Post\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()->count(5)->create();
    }
}
