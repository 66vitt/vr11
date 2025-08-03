<?php

namespace App\Orchid\Layouts\Rate;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class EditRateLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('rate.city')
                ->type('text')
                ->title('Стоимость заказа по городу (до 50км).'),
            Input::make('rate.region100')
                ->type('text')
                ->title('Стоимость заказа до 100км.'),
            Input::make('rate.region150')
                ->type('text')
                ->title('Стоимость заказа до 150км.'),
            Input::make('rate.region200')
                ->type('text')
                ->title('Стоимость заказа до 200км.'),
            Input::make('rate.region250')
                ->type('text')
                ->title('Стоимость заказа до 250км.'),
            Input::make('rate.region300')
                ->type('text')
                ->title('Стоимость заказа до 300км.'),
            Input::make('rate.region350')
                ->type('text')
                ->title('Стоимость заказа до 350км.'),
            Input::make('rate.region400')
                ->type('text')
                ->title('Стоимость заказа до 400км.'),
            Input::make('rate.region450')
                ->type('text')
                ->title('Стоимость заказа до 450км.'),
            Input::make('rate.city_limit_time')
                ->type('text')
                ->title('Норма времени на заказ по городу.'),
            Input::make('rate.hour_cost_over_limit')
                ->type('text')
                ->title('Стоимость 1 часа сверх нормы.'),
            Input::make('rate.ot_cost')
                ->type('text')
                ->title('Стоимость погрузки опентопа.'),
            Input::make('rate.self_cost')
                ->type('text')
                ->title('Стоимость погрузки 30м3.'),
            Input::make('rate.odd_point_cost')
                ->type('text')
                ->title('Стоимость дополнительного адреса погрузки/выгрузки.'),
        ];
    }
}
