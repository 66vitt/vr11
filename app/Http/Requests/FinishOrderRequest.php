<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinishOrderRequest extends FormRequest
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
            'order.end_km' => ['nullable', 'integer'],
            'order.end_time' => ['date_format:Y-m-d h:m', 'nullable'],
            'order.ot_number' => ['nullable', 'integer'],
            'order.self_number' => ['nullable', 'integer'],
            'order.cash' => ['nullable', 'integer'],
            'order.sum' => ['integer'],
            'order.description' => ['string', 'nullable']
        ];
    }
}
