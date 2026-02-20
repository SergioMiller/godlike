<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    protected static null|string $password;

    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'publisher' => $this->faker->word(),
            'genre' => $this->faker->word(),
            'publication_date' => $this->faker->date(),
            'amount_of_words' => $this->faker->randomDigit(),
            'price' => $this->faker->randomDigit() * 100,
        ];
    }
}
