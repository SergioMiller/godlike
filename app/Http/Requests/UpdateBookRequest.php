<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UpdateBookRequest',
    properties: [
        new OA\Property(property: 'title', type: 'string', maximum: 255, minimum: 1, example: 'Name of book'),
        new OA\Property(property: 'publisher', type: 'string', maximum: 255, minimum: 1, example: 'Good book LLC'),
        new OA\Property(property: 'genre', type: 'string', maximum: 255, minimum: 1, example: 'Comedy'),
        new OA\Property(property: 'publication_date', type: 'date', example: '26-12-12'),
        new OA\Property(property: 'amount_of_words', type: 'integer', maximum: 50000, minimum: 1, example: 100500),
        new OA\Property(property: 'price', type: 'integer', maximum: 999999, minimum: 0, example: 5.5),
        new OA\Property(property: 'authors', type: 'array', items: new OA\Items(type: 'integer', example: 1)),
    ]
)]
final class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'publisher' => ['sometimes', 'string', 'max:255'],
            'genre' => ['sometimes', 'string', 'max:255'],
            'publication_date' => ['sometimes', 'string', new Date()->format('Y-m-d')],
            'amount_of_words' => ['sometimes', 'integer', 'min:1', 'max:50000'],
            'price' => ['sometimes', 'numeric', 'min:0', 'max:999999'],
            'authors' => ['array'],
            'authors.*' => ['required', 'integer'],
        ];
    }
}
