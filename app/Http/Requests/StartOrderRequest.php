<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartOrderRequest extends FormRequest
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
            'order.start_km' => ['required', 'integer'],
            'order.client_id' => ['required', 'integer'],
            'order.user_id' => ['integer'],
        ];
    }
    public function messages(){
        return [
            'order.start_km.required' => 'Поле обязятельно для заполнения',
            'order.start_km.integer' => 'Введите числовое значение',
            'order.client_id.required' => 'Поле обязятельно для заполнения',
            'order.client_id.integer' => 'Проверьте введенные данные',
        ];
    }
}
