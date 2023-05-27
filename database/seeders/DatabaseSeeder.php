<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // SEED USERS
        \App\Models\v1\User::factory(10)->create();

        \App\Models\v1\User::factory()->create([
            'name'     => 'Edimilson Assis',
            'email'    => 'edy-assis@hotmail.com',
            'password' => 'senha@123',
        ]);
        // SEED USERS

        // SEED BOOKS
        \App\Models\v1\Book::factory(10)->create();
        // SEED BOOKS

        // SEED  BOOK INDEXES
        for ($i = 0; $i < 100; $i++) {
            $books_id         = \App\Models\v1\Book::all()->pluck('id')->toArray();
            $books_indexes_id = \App\Models\v1\BookIndex::all()->pluck('id')->toArray();

            \App\Models\v1\BookIndex::factory()->create([
                'titulo'        => fake()->sentence(),
                'pagina'        => fake()->randomNumber(),
                'livro_id'      => fake()->randomElements($books_id)[0],
                'indice_pai_id' => $books_indexes_id ? fake()->randomElements($books_indexes_id)[0] : null,
            ]);
        }
        // SEED  BOOK INDEXES
    }
}