<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'BookResource',
    required: [
        'id',
        'title',
        'publisher',
        'genre',
        'publication_date',
        'amount_of_words',
        'price',
        'authors',
    ],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', maximum: 255, minimum: 1, example: 'Name of book'),
        new OA\Property(property: 'publisher', type: 'string', maximum: 255, minimum: 1, example: 'Good book LLC'),
        new OA\Property(property: 'genre', type: 'string', maximum: 255, minimum: 1, example: 'Comedy'),
        new OA\Property(property: 'publication_date', type: 'date', example: '26-12-12'),
        new OA\Property(property: 'amount_of_words', type: 'integer', maximum: 50000, minimum: 1, example: 100500),
        new OA\Property(property: 'price', type: 'integer', maximum: 999999, minimum: 0, example: 5.5),
        new OA\Property(property: 'authors', type: 'array', items: new OA\Items(
            ref: '#/components/schemas/AuthorResource'
        )),
    ]
)]
/**
 * @property Book $resource
 */
class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'publisher' => $this->resource->publisher,
            'genre' => $this->resource->genre,
            'publication_date' => $this->resource->publication_date,
            'amount_of_words' => (int) $this->resource->amount_of_words,
            'price' => $this->when(
                condition: $this->resource->price > 0,
                value: round($this->resource->price / 100, 2),
                default: 0
            ),
            'authors' => AuthorResource::collection($this->resource->authors),
        ];
    }
}
