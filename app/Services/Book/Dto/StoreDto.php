<?php
declare(strict_types=1);

namespace App\Services\Book\Dto;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

final readonly class StoreDto implements Arrayable
{
    public function __construct(
        private string $title,
        private string $publisher,
        private string $genre,
        private Carbon $publication_date,
        private int $amount_of_words,
        private int $price,
        private array $authors,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            publisher: $data['publisher'],
            genre: $data['genre'],
            publication_date: Carbon::createFromDate($data['publication_date']),
            amount_of_words: $data['amount_of_words'],
            price: $data['price'],
            authors: $data['authors'],
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'publisher' => $this->publisher,
            'genre' => $this->genre,
            'publication_date' => $this->publication_date,
            'amount_of_words' => $this->amount_of_words,
            'price' => $this->price,
            'authors' => $this->authors,
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getPublicationDate(): Carbon
    {
        return $this->publication_date;
    }

    public function getAmountOfWords(): int
    {
        return $this->amount_of_words;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }
}
