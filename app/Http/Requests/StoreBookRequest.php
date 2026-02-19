<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;

final class StoreBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'publication_date' => ['required', 'string', new Date()->format('Y-m-d')],
            'amount_of_words' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'integer', 'min:1'],
            'authors' => ['array'],
            'authors.*' => ['required', 'integer'],
        ];
    }
}
