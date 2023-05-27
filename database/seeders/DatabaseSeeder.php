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
        // \App\Models\v1\User::factory(10)->create();

        // \App\Models\v1\User::factory()->create([
        //     'name'     => 'Edimilson Assis',
        //     'email'    => 'edy-assis@hotmail.com',
        //     'password' => 'senha@123',
        // ]);

        \App\Models\v1\Book::factory(10)->create();

        // \App\Models\v1\BookIndex::factory(10)->create();
    }
}