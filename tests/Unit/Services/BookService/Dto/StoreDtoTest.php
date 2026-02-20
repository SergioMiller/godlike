<?php
declare(strict_types=1);

namespace Tests\Unit\Services\BookService\Dto;

use App\Services\Book\Dto\StoreDto;
use Tests\TestCase;

/**
 * @see StoreDto
 */
class StoreDtoTest extends TestCase
{
    public function test_store_dto(): void
    {
        $data = [
            'title' => $this->faker->name(),
            'publisher' => $this->faker->word(),
            'genre' => $this->faker->word(),
            'publication_date' => $this->faker->date(),
            'amount_of_words' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomFloat(2),
            'authors' => [1, 2, 3],
        ];

        $dto = StoreDto::fromArray($data);

        $this->assertSame($data['title'], $dto->getTitle());
        $this->assertSame($data['publisher'], $dto->getPublisher());
        $this->assertSame($data['genre'], $dto->getGenre());
        $this->assertSame($data['publication_date'], $dto->getPublicationDate()->format('Y-m-d'));
        $this->assertSame($data['amount_of_words'], $dto->getAmountOfWords());
        $this->assertSame($data['price'], $dto->getPrice());
        $this->assertSame($data['authors'], $dto->getAuthors());
    }
}
