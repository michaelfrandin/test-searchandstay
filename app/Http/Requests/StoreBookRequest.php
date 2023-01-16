<?php

namespace App\Http\Requests;

use App\Rules\Isbn;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'isbn' => ['required', 'numeric', 'unique:books,isbn', new Isbn()],
            'value' => 'nullable|decimal:1,2'
        ];
    }
}
