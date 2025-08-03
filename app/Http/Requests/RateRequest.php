<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
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
            'rate.city' => 'integer',
            'rate.region100' => 'required||integer',
            'rate.region150' => 'required||integer',
            'rate.region200' => 'required||integer',
            'rate.region250' => 'required||integer',
            'rate.region300' => 'required||integer',
            'rate.region350' => 'required||integer',
            'rate.region400' => 'required||integer',
            'rate.region450' => 'required||integer',
            'rate.city_limit_time' => 'required||integer',
            'rate.hour_cost_over_limit' => 'required||integer',
            'rate.ot_cost' => 'required||integer',
            'rate.self_cost' => 'required||integer',
            'rate.odd_point_cost' => 'required||integer',
        ];
    }

//    public function messages()
//    {
//        return [
//            'city.required' => 'Данное поле обязательно к заполнению',
//            'city.integer' => 'Значение должно быть числом',
//            'region100.required' => 'Данное поле обязательно к заполнению',
//            'region100.integer' => 'Значение должно быть числом',
//            'region150.required' => 'Данное поле обязательно к заполнению',
//            'region150.integer' => 'Значение должно быть числом',
//            'region200.required' => 'Данное поле обязательно к заполнению',
//            'region200.integer' => 'Значение должно быть числом',
//            'region250.required' => 'Данное поле обязательно к заполнению',
//            'region250.integer' => 'Значение должно быть числом',
//            'region300.required' => 'Данное поле обязательно к заполнению',
//            'region300.integer' => 'Значение должно быть числом',
//            'region350.required' => 'Данное поле обязательно к заполнению',
//            'region350.integer' => 'Значение должно быть числом',
//            'region400.required' => 'Данное поле обязательно к заполнению',
//            'region400.integer' => 'Значение должно быть числом',
//            'region450.required' => 'Данное поле обязательно к заполнению',
//            'region450.integer' => 'Значение должно быть числом',
//            'city_limit_time.required' => 'Данное поле обязательно к заполнению',
//            'city_limit_time.integer' => 'Значение должно быть числом',
//            'hour_cost_over_limit.required' => 'Данное поле обязательно к заполнению',
//            'hour_cost_over_limit.integer' => 'Значение должно быть числом',
//            'ot_cost.required' => 'Данное поле обязательно к заполнению',
//            'ot_cost.integer' => 'Значение должно быть числом',
//            'self_cost.required' => 'Данное поле обязательно к заполнению',
//            'self_cost.integer' => 'Значение должно быть числом',
//            'odd_point_cost.required' => 'Данное поле обязательно к заполнению',
//            'odd_point_cost.integer' => 'Значение должно быть числом',
//        ];
//    }
}
