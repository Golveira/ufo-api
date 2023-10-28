<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DossierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:500'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'The title of the dossier.',
                'example' => 'Investigation of UFOs in Brazil.',
            ],
            'description' => [
                'description' => 'The description of the dossier.',
                'example' => 'This dossier contains all the information about UFOs in Brazil.',
            ],
        ];
    }
}
