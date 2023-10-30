<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keywords' => ['string'],
            'country' => ['string'],
            'state' => ['string'],
            'city' => ['string'],
            'dateFrom' => ['date'],
            'dateTo' => ['date', 'after:dateFrom'],
            'sortBy' => ['string', Rule::in(['date'])],
            'sortOrder' => ['string', Rule::in(['asc', 'desc'])],
        ];
    }

    public function messages()
    {
        return [
            'keywords.string' => 'The keywords cannot be empty',
            'country.string' => 'The country cannot be empty',
            'state.string' => 'The state cannot be empty',
            'city.string' => 'The city cannot be empty',
            'dateFrom.date' => 'The dateFrom must be a valid date',
            'dateTo.date' => 'The dateTo must be a valid date',
            'dateTo.after' => 'The dateTo must be after the dateFrom',
        ];
    }

    public function queryParameters(): array
    {
        return [
            'keywords' => [
                'description' => 'Keywords to search for',
                'example' => 'ufo',
            ],
            'country' => [
                'description' => 'Country to search for',
                'example' => 'USA',
            ],
            'state' => [
                'description' => 'State to search for',
                'example' => 'California',
            ],
            'city' => [
                'description' => 'City to search for',
                'example' => 'Los Angeles',
            ],
            'dateFrom' => [
                'description' => 'Start date to search for',
                'example' => '2000-01-01',
            ],
            'dateTo' => [
                'description' => 'End date to search for',
                'example' => '2010-01-01',
            ],
            'sortBy' => [
                'description' => 'Field to sort by',
                'example' => 'date',
            ],
            'sortOrder' => [
                'description' => 'Sort order',
                'example' => 'asc',
            ],
        ];
    }
}
