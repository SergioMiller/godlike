<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'StoreBookRequest',
    required: [
        'title',
        'publisher',
        'genre',
        'publication_date',
        'amount_of_words',
        'price',
        'authors',
    ],
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
final class StoreBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'publication_date' => ['required', 'string', new Date()->format('Y-m-d')],
            'amount_of_words' => ['required', 'integer', 'min:1', 'max:50000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999'],
            'authors' => ['array'],
            'authors.*' => ['required', 'integer'],
        ];
    }
}
