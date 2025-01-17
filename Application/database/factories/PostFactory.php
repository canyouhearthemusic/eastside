<?php

namespace Database\Factories;

use App\Modules\Post\Enums\Status;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Post\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'status'      => Status::ACTIVE,
            'title'       => $this->faker->name,
            'description' => $this->faker->text,
        ];
    }
}
