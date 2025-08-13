<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Client;
use App\Models\Truck;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class StartOrderLayout extends Rows
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
            Input::make('order.start_km')
                ->title('Начальный пробег')
                ->placeholder('Начальный пробег')
                ->required(),
            Group::make([
                Select::make('order.client_id')
                    ->title('Заказчик')
                    ->fromModel(Client::class, 'title'),
                Link::make()
                    ->class('fs-2 text-primary')
                    ->icon('bs.person-plus')
                    ->route('client.create')
            ])->alignEnd(),


            Select::make('order.truck_id')
                ->title('Автомобиль')
                ->fromModel(Truck::class, 'number'),
//            Relation::make('order.client_id.')
//                ->title('Заказчик')
//                ->fromModel(Client::class, 'title')
//                ->allowAdd(),
//            Relation::make('order.truck_id')
//                ->value($this->query->get('order_last') ? $this->query->get('order_last')->truck_id : '')
//                ->title('Автомобиль')
//                ->fromModel(Truck::class, 'number'),
//            Map::make('place')
//                ->title('Object on the map')
//                ->help('Enter the coordinates, or use the search'),
        ];
    }
}
