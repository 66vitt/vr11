<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Client;
use App\Models\Order;
use App\Models\Truck;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class FinishOrderLayout extends Rows
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
            Input::make('order.end_km')
                ->title('Пробег по завершении заказа')
                ->required(),
            Input::make('order.ot_number')
                ->title('Количество погруженных опентопов')
                ->type('number')
                ->min(0)
                ->value(0),
            Input::make('order.self_number')
                ->type('number')
                ->title('Количество погруженных/выгруженных банок 30м3')
                ->min(0)
                ->value(0),
            Input::make('order.cash')
                ->title('Полученная наличная оплата')
                ->value(0),
            TextArea::make('order.description')
                ->rows(5),
//            Attach::make('order.attachments')
//                ->multiple()
//                ->storage('orders_images')
//                ->title('Загрузить изображение')
//                ->class('zalupa')
//                ->horizontal()
//                ->withoutFormType(),
        ];
    }
}
