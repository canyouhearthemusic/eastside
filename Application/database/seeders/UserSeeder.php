<?php

namespace Database\Seeders;

use App\Modules\User\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'John Doe',
            'email'    => 'johndoe@example.com',
            'password' => 'johndoe123',
        ]);

        User::factory()->create([
            'name'     => 'Jane Doe',
            'email'    => 'janedoe@example.com',
            'password' => 'janedoe123',
        ]);
    }
}
