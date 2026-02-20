<?php
declare(strict_types=1);

namespace Tests\Unit\Services\BookService;

use App\Models\Book;
use App\Services\Book\BookService;
use App\Services\Book\Dto\StoreDto;
use App\Services\Book\Dto\UpdateDto;
use Closure;
use Database\Factories\AuthorFactory;
use Database\Factories\BookFactory;
use Faker\Factory as Faker;
use Generator;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Throwable;

/**
 * @see BookService
 */
class BookServiceTest extends TestCase
{
    private BookService $bookService;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bookService = $this->app->make(BookService::class);
    }

    /**
     * @throws Throwable
     */
    public function test_store(): void
    {
        $authors = AuthorFactory::new()->count(2)->create();

        $data = StoreDto::fromArray([
            'title' => $this->faker->name(),
            'publisher' => $this->faker->word(),
            'genre' => $this->faker->word(),
            'publication_date' => $this->faker->date(),
            'amount_of_words' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomNumber(2),
            'authors' => $authors->pluck('id')->toArray(),
        ]);
        $book = $this->bookService->store($data);

        $this->assertSame($data->getTitle(), $book->title);
        $this->assertSame($data->getPublisher(), $book->publisher);
        $this->assertSame($data->getGenre(), $book->genre);
        $this->assertSame($data->getPublicationDate()->format('Y-m-d'), $book->publication_date->format('Y-m-d'));
        $this->assertSame($data->getAmountOfWords(), $book->amount_of_words);
        $this->assertSame($data->getPrice(), $book->price / 100);
        $this->assertSame($data->getAuthors(), $book->authors->pluck('id')->toArray());
    }

    /**
     * @throws Throwable
     */
    public function test_update_full(): void
    {
        $book = BookFactory::new()->create();
        $authorsOld = AuthorFactory::new()->count(2)->create();
        $book->authors()->attach($authorsOld->pluck('id')->toArray());

        $authorsNew = AuthorFactory::new()->count(2)->create();

        $data = UpdateDto::fromArray([
            'title' => $this->faker->name(),
            'publisher' => $this->faker->word(),
            'genre' => $this->faker->word(),
            'publication_date' => $this->faker->date(),
            'amount_of_words' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomNumber(2),
            'authors' => $authorsNew->pluck('id')->toArray(),
        ]);

        $book = $this->bookService->update($book, $data);

        $this->assertSame($data->getTitle(), $book->title);
        $this->assertSame($data->getPublisher(), $book->publisher);
        $this->assertSame($data->getGenre(), $book->genre);
        $this->assertSame($data->getPublicationDate()->format('Y-m-d'), $book->publication_date->format('Y-m-d'));
        $this->assertSame($data->getAmountOfWords(), $book->amount_of_words);
        $this->assertSame($data->getPrice(), $book->price / 100);
        $this->assertSame($data->getAuthors(), $book->authors->pluck('id')->toArray());
    }

    /**
     * @throws Throwable
     */
    #[DataProvider('dataProvider')]
    public function test_update_part(UpdateDto $dto, Closure $assert): void
    {
        $book = BookFactory::new()->create();
        $assert($dto, clone $book, $this->bookService->update($book, $dto));
    }

    public static function dataProvider(): Generator
    {
        $faker = Faker::create();

        yield 'title' => [
            'dto' => UpdateDto::fromArray([
                'publisher' => $faker->word(),
                'genre' => $faker->word(),
                'publication_date' => $faker->date(),
                'amount_of_words' => $faker->randomDigit(),
                'price' => $faker->randomNumber(2),
            ]),
            'assert' => static function (UpdateDto $dto, Book $book, Book $bookUpdated) {
                self::assertSame($book->title, $bookUpdated->title);
            },
        ];

        yield 'publisher' => [
            'dto' => UpdateDto::fromArray([
                'title' => $faker->word(),
                'genre' => $faker->word(),
                'publication_date' => $faker->date(),
                'amount_of_words' => $faker->randomDigit(),
                'price' => $faker->randomNumber(2),
            ]),
            'assert' => static function (UpdateDto $dto, Book $book, Book $bookUpdated) {
                self::assertSame($book->publisher, $bookUpdated->publisher);
            },
        ];

        yield 'genre' => [
            'dto' => UpdateDto::fromArray([
                'title' => $faker->word(),
                'publisher' => $faker->word(),
                'publication_date' => $faker->date(),
                'amount_of_words' => $faker->randomDigit(),
                'price' => $faker->randomNumber(2),
            ]),
            'assert' => static function (UpdateDto $dto, Book $book, Book $bookUpdated) {
                self::assertSame($book->genre, $bookUpdated->genre);
            },
        ];

        yield 'publication_date' => [
            'dto' => UpdateDto::fromArray([
                'title' => $faker->word(),
                'genre' => $faker->word(),
                'publisher' => $faker->word(),
                'amount_of_words' => $faker->randomDigit(),
                'price' => $faker->randomNumber(2),
            ]),
            'assert' => static function (UpdateDto $dto, Book $book, Book $bookUpdated) {
                self::assertSame(
                    $book->publication_date->format('Y-m-d'),
                    $bookUpdated->publication_date->format('Y-m-d')
                );
            },
        ];

        yield 'amount_of_words' => [
            'dto' => UpdateDto::fromArray([
                'title' => $faker->word(),
                'publisher' => $faker->word(),
                'genre' => $faker->word(),
                'publication_date' => $faker->date(),
                'price' => $faker->randomNumber(2),
            ]),
            'assert' => static function (UpdateDto $dto, Book $book, Book $bookUpdated) {
                self::assertSame($book->amount_of_words, $bookUpdated->amount_of_words);
            },
        ];
    }

    public function test_destroy(): void
    {
        $book = BookFactory::new()->create();

        $this->bookService->destroy($book);

        $this->assertNull($book->fresh());
    }
}
