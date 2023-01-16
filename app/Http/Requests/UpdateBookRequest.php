<?php

namespace App\Http\Requests;

use App\Rules\Isbn;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable',
            'isbn' => ['nullable', 'numeric', 'unique:books,isbn', new Isbn()],
            'value' => 'nullable|decimal:1,2'
        ];
    }
}
