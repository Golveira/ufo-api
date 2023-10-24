<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'summary' => ['required', 'string', 'max:150'],
            'details' => ['required', 'string', 'max:1500'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'duration' => ['required', 'numeric'],
            'number_of_observers'  => ['required', 'numeric'],
            'object_shape' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'max:2048'],
        ];
    }
}
