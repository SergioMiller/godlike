<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'price' => (int) $this->resource->price / 100,
            'authors' => AuthorResource::collection($this->resource->authors),
        ];
    }
}
