<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images' => ['required', 'array', 'max:10'],
            'images.*' => ['image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'You must upload at least one image.',
            'images.array' => 'The images must be an array.',
            'images.max' => 'You can upload up to 10 images.',
            'images.*.image' => 'The file must be an image.',
            'images.*.max' => 'The image must be at most 2MB.',
        ];
    }
}
