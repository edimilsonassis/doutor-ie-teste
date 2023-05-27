<?php

namespace Database\Factories\v1;

use App\Models\v1\Book;
use App\Models\v1\BookIndex;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\v1\BookIndex>
 */
class BookIndexFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $books_id         = Book::all()->pluck('id')->toArray();
        $books_indexes_id = BookIndex::all()->pluck('id')->toArray();

        return [
            'titulo'        => fake()->sentence(10),
            'pagina'        => fake()->randomNumber(),
            'livro_id'      => fake()->randomElements($books_id)[0],
            'indice_pai_id' => fake()->randomElements($books_indexes_id)[0],
        ];
    }
}