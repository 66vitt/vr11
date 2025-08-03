<?php

namespace App\Orchid\Layouts\Rate;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CurrentRateLayout extends Rows
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
                ->title('Стоимость заказа по городу (до 50км).')
                ->readonly(),
            Input::make('rate.region100')
                ->type('text')
                ->title('Стоимость заказа до 100км.')
                ->readonly(),
            Input::make('rate.region150')
                ->type('text')
                ->title('Стоимость заказа до 150км.')
                ->readonly(),
            Input::make('rate.region200')
                ->type('text')
                ->title('Стоимость заказа до 200км.')
                ->readonly(),
            Input::make('rate.region250')
                ->type('text')
                ->title('Стоимость заказа до 250км.')
                ->readonly(),
            Input::make('rate.region300')
                ->type('text')
                ->title('Стоимость заказа до 300км.')
                ->readonly(),
            Input::make('rate.region350')
                ->type('text')
                ->title('Стоимость заказа до 350км.')
                ->readonly(),
            Input::make('rate.region400')
                ->type('text')
                ->title('Стоимость заказа до 400км.')
                ->readonly(),
            Input::make('rate.region450')
                ->type('text')
                ->title('Стоимость заказа до 450км.')
                ->readonly(),
            Input::make('rate.city_limit_time')
                ->type('text')
                ->title('Норма времени на заказ по городу.')
                ->readonly(),
            Input::make('rate.hour_cost_over_limit')
                ->type('text')
                ->title('Стоимость 1 часа сверх нормы.')
                ->readonly(),
            Input::make('rate.ot_cost')
                ->type('text')
                ->title('Стоимость погрузки опентопа.')
                ->readonly(),
            Input::make('rate.self_cost')
                ->type('text')
                ->title('Стоимость погрузки 30м3.')
                ->readonly(),
            Input::make('rate.odd_point_cost')
                ->type('text')
                ->title('Стоимость дополнительного адреса погрузки/выгрузки.')
                ->readonly(),
            Input::make('rate.created_at')
                ->type('text')
                ->title('Дата изменения тарифов.')
                ->readonly(),
        ];
    }
}
