<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(27)->create()->each(function ($book){
            $numRevs = random_int(5, 20);

            Review::factory()->count($numRevs)
                ->good()
                ->for($book)
                ->create();
        });

        Book::factory(33)->create()->each(function ($book){
            $numRevs = random_int(5, 15);

            Review::factory()->count($numRevs)
                ->average()
                ->for($book)
                ->create();
        });

        Book::factory(30)->create()->each(function ($book){
            $numRevs = random_int(5, 10);

            Review::factory()->count($numRevs)
                ->bad()
                ->for($book)
                ->create();
        });
    }
}
