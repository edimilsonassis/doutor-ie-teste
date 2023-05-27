<?php

namespace Database\Factories\v1;

use App\Models\v1\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\v1\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users_id = User::all()->pluck('id')->toArray();

        return [
            'titulo'                => fake()->sentence(),
            'usuario_publicador_id' => fake()->randomElements($users_id)[0]
        ];
    }
}