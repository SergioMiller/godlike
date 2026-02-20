<?php
declare(strict_types=1);

namespace App\Services\Book;

use App\Interfaces\AuthorRepositoryInterface;
use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use App\Services\Book\Dto\StoreDto;
use App\Services\Book\Dto\UpdateDto;
use Illuminate\Database\DatabaseManager;
use Throwable;

/**
 * @see BookServiceTest
 */
readonly class BookService
{
    public function __construct(
        private DatabaseManager $databaseManager,
        private BookRepositoryInterface $bookRepository,
        private AuthorRepositoryInterface $authorRepository,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function store(StoreDto $data): Book
    {
        $book = new Book();
        $book->title = $data->getTitle();
        $book->publisher = $data->getPublisher();
        $book->genre = $data->getGenre();
        $book->publication_date = $data->getPublicationDate()->format('Y-m-d');
        $book->amount_of_words = $data->getAmountOfWords();
        $book->price = $data->getPrice() * 100;

        return $this->databaseManager->transaction(function () use ($book, $data) {
            $book = $this->bookRepository->save($book);
            $authors = $this->authorRepository->getByIds($data->getAuthors());
            $book->authors()->attach($authors->pluck('id')->toArray());

            return $book;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(Book $book, UpdateDto $data)
    {
        $book->fill($data->toArray());

        if (null !== $data->getPrice()) {
            $book->price = $data->getPrice() * 100;
        }

        return $this->databaseManager->transaction(function () use ($book, $data) {
            $book = $this->bookRepository->save($book);

            if (null === $data->getAuthors()) {
                return $book;
            }

            $authors = $this->authorRepository->getByIds($data->getAuthors());
            $book->authors()->sync($authors->pluck('id')->toArray());

            return $book;
        });
    }

    public function destroy(Book $book): bool
    {
        return $this->bookRepository->destroy($book);
    }
}
