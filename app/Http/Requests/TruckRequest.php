<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TruckRequest extends FormRequest
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
            'truck.model' => ['required', 'string'],
            'truck.number' => ['required', 'string'],
            'truck.color' => ['required', 'string'],
            'truck.assicurazione' => ['nullable', ],
            'truck.takho_to' => ['nullable', 'date', 'date_format:Y-m-d'],
            'truck.to_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'truck.service_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'truck.to_km' => ['nullable', 'numeric'],
            'truck.now_km' => ['nullable', 'numeric'],
            'truck.total_height' => ['nullable', 'numeric'],
            'truck.body_height' => ['nullable', 'numeric'],
            'truck.body_width' => ['nullable', 'numeric'],
            'truck.body_length' => ['nullable', 'numeric'],
            'truck.tonnage' => ['nullable', 'numeric'],
            'truck.image_id' => ['nullable']
        ];
    }
}
