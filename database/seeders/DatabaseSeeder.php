<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Database\Factories\AuthorFactory;
use Database\Factories\BookFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // UserFactory::new()->create();

        //        UserFactory::new()->create([
        //            'name' => 'Test User',
        //            'email' => 'test@example.com',
        //        ]);

        /**
         * @var Book[] $books
         */
        $books = BookFactory::new()->count(10)->create();
        $authors = AuthorFactory::new()->count(10)->create();

        foreach ($books as $book) {
            $book->authors()->attach($authors->random(3)->pluck('id')->toArray());
        }
    }
}
