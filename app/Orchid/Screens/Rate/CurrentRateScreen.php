<?php

namespace App\Orchid\Screens\Rate;

use App\Models\Rate;
use App\Orchid\Layouts\Rate\CurrentRateLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class CurrentRateScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'rate' => Rate::orderBy('id', 'desc')->first(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Действующие тарифы водителей';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
         return [
             Link::make('Редактировать тарифы')
                 ->icon('pencil')
                 ->type(Color::PRIMARY)
                 ->route('rates.edit')
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
            CurrentRateLayout::class,
        ];
    }
}
