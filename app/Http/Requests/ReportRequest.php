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
            'duration' => ['required', 'integer'],
            'number_of_observers'  => ['required', 'numeric'],
            'object_shape' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'summary' => [
                'description' => 'The summary of the report',
                'example' => 'I saw a UFO'
            ],
            'details' => [
                'description' => 'The details of the report',
                'example' => 'I saw a UFO in the sky'
            ],
            'country' => [
                'description' => 'The country of the report',
                'example' => 'US'
            ],
            'state' => [
                'description' => 'The state of the report',
                'example' => 'California'
            ],
            'city' => [
                'description' => 'The city of the report',
                'example' => 'Los Angeles'
            ],
            'lat' => [
                'description' => 'The latitude of the report',
                'example' => '34.052235'
            ],
            'long' => [
                'description' => 'The longitude of the report',
                'example' => '-118.243683'
            ],
            'date' => [
                'description' => 'The date of the report',
                'example' => '2021-01-01'
            ],
            'duration' => [
                'description' => 'The duration of the sighting in seconds',
                'example' => '60'
            ],
            'number_of_observers' => [
                'description' => 'The number of observers',
                'example' => '1'
            ],
            'object_shape' => [
                'description' => 'The shape of the object',
                'example' => 'Triangle'
            ],
        ];
    }
}
