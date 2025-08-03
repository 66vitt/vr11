<?php

namespace App\Orchid\Layouts\Truck;

use App\Models\Truck;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TruckListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'trucks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('model', 'Модель')
                ->width('150px'),
            TD::make('number', 'Гос номер')
                ->width('150px')
                ->cantHide()
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function(Truck $truck){
                    return Link::make($truck->number)
                        ->route('trucks.show', $truck);
                }),
            TD::make('color', 'Цвет')->width('200px'),
            TD::make('created_at', 'Дата добавления')->defaultHidden(),
        ];
    }
}
