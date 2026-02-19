<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;

final class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'publisher' => ['sometimes', 'string', 'max:255'],
            'genre' => ['sometimes', 'string', 'max:255'],
            'publication_date' => ['sometimes', 'string', new Date()->format('Y-m-d')],
            'amount_of_words' => ['sometimes', 'integer', 'min:1'],
            'price' => ['sometimes', 'integer', 'min:1'],
            'authors' => ['sometimes', 'array'],
            'authors.*' => ['integer'],
        ];
    }
}
