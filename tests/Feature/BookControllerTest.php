<?php
declare(strict_types=1);

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Database\Factories\AuthorFactory;
use Database\Factories\BookFactory;
use Tests\TestCase;

/**
 * @see BookController
 */
class BookControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Book::query()->truncate();
    }

    public function test_index(): void
    {
        BookFactory::new()->count(30)->create();

        $response = $this->getJson(route('books.index'))
            ->assertOk()
            ->json();

        $this->assertSame(30, $response['pagination']['total']);
        $this->assertSame(1, $response['pagination']['current_page']);
        $this->assertSame(2, $response['pagination']['last_page']);

        $this->assertCount(15, $response['data']);
    }

    public function test_store(): void
    {
        $authors = AuthorFactory::new()->count(2)->create();
        $payload = [
            'title' => $this->faker->name(),
            'publisher' => $this->faker->word(),
            'genre' => $this->faker->word(),
            'publication_date' => $this->faker->date(),
            'amount_of_words' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomNumber(2),
            'authors' => $authors->pluck('id')->toArray(),
        ];

        $response = $this->postJson(route('books.store'), $payload)
            ->assertCreated()
            ->json('data');

        $this->assertSame($payload['title'], $response['title']);
        $this->assertSame($payload['publisher'], $response['publisher']);
        $this->assertSame($payload['genre'], $response['genre']);
        $this->assertSame($payload['publication_date'], $response['publication_date']);
        $this->assertSame($payload['amount_of_words'], $response['amount_of_words']);
        $this->assertSame($payload['price'], $response['price']);

        foreach ($response['authors'] as $author) {
            $this->assertContains($author['id'], $payload['authors']);
        }
    }

    public function test_update_not_found(): void
    {
        $this->patchJson(route('books.update', 99999))
            ->assertNotFound();
    }

    public function test_update(): void
    {
        $authors = AuthorFactory::new()->count(2)->create();

        $payload = [
            'title' => $this->faker->name(),
            'publisher' => $this->faker->word(),
            'genre' => $this->faker->word(),
            'publication_date' => $this->faker->date(),
            'amount_of_words' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomNumber(2),
            'authors' => $authors->pluck('id')->toArray(),
        ];
        $book = BookFactory::new()->create();

        $response = $this->patchJson(route('books.update', $book->getKey()), $payload)
            ->assertOk()
            ->json('data');

        $this->assertSame($payload['title'], $response['title']);
        $this->assertSame($payload['publisher'], $response['publisher']);
        $this->assertSame($payload['genre'], $response['genre']);
        $this->assertSame($payload['publication_date'], $response['publication_date']);
        $this->assertSame($payload['amount_of_words'], $response['amount_of_words']);
        $this->assertSame($payload['price'], $response['price']);

        foreach ($response['authors'] as $author) {
            $this->assertContains($author['id'], $payload['authors']);
        }
    }

    public function test_destroy_not_found(): void
    {
        $this->patchJson(route('books.destroy', 99999))
            ->assertNotFound();
    }

    public function test_destroy(): void
    {
        $book = BookFactory::new()->create();

        $this->deleteJson(route('books.destroy', $book->getKey()))
            ->assertNoContent();

        $this->assertNull($book->fresh());
    }
}
