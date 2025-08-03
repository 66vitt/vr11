<?php

namespace App\Orchid\Screens\Truck;

use App\Models\Truck;
use App\Orchid\Layouts\Truck\TruckListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class TruckListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'trucks' => Truck::filters()->defaultSort('number')->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Автотранспорт');
    }

    public function description(): ?string
    {
        return __('Список автотранспорта предприятия');
    }

//    public function permission(): ?iterable
//    {
//        return [
//            'trucks',
//        ];
//    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить машину')
                ->icon('pencil')
                ->type(Color::PRIMARY)
                ->route('trucks.create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            TruckListLayout::class,
        ];
    }
}
