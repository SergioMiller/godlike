<?php
declare(strict_types=1);

namespace App\Services\Book\Dto;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

final readonly class UpdateDto implements Arrayable
{
    public function __construct(
        private string|null $title,
        private string|null $publisher,
        private string|null $genre,
        private Carbon|null $publication_date,
        private int|null $amount_of_words,
        private int|null $price,
        private array|null $authors,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            publisher: $data['publisher'] ?? null,
            genre: $data['genre'] ?? null,
            publication_date: !empty($data['publication_date']) ? Carbon::createFromDate($data['publication_date']) : null,
            amount_of_words: $data['amount_of_words'] ?? null,
            price: $data['price'] ?? null,
            authors: $data['authors'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'publisher' => $this->publisher,
            'genre' => $this->genre,
            'publication_date' => $this->publication_date,
            'amount_of_words' => $this->amount_of_words,
            'price' => $this->price,
            'authors' => $this->authors,
        ]);
    }

    public function getTitle(): string|null
    {
        return $this->title;
    }

    public function getPublisher(): string|null
    {
        return $this->publisher;
    }

    public function getGenre(): string|null
    {
        return $this->genre;
    }

    public function getPublicationDate(): Carbon|null
    {
        return $this->publication_date;
    }

    public function getAmountOfWords(): int|null
    {
        return $this->amount_of_words;
    }

    public function getPrice(): int|null
    {
        return $this->price;
    }

    public function getAuthors(): array|null
    {
        return $this->authors;
    }
}
