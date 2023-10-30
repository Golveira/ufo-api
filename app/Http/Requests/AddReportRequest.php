<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_id' => ['required', 'exists:reports,id'],
        ];
    }
}
