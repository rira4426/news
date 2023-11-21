<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'providers' => 'required|array|min:1',
            'providers.*' => 'in:bbc,theguardian,nytimes',
            'query' => 'required',
            'page' => 'required|integer|min:1',
            'categories' => 'array|min:1',
            'authors' => 'array|min:1',

            'category' => 'string',
            'headline' => 'string',
            'date' => 'string|date',
            'author' => 'string',
        ];
    }
}
