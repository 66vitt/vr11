<?php

namespace App\Orchid\Screens\Rate;

use App\Http\Requests\RateRequest;
use App\Models\Rate;
use App\Orchid\Layouts\Rate\EditRateLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class EditRateScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'edit_rate'
        ];
    }
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
        return 'Редактирование тарифов';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('pencil')
                ->method('editRates')
                ->type(Color::PRIMARY),
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
            EditRateLayout::class,
        ];
    }

    public function editRates(Rate $rate, RateRequest $request)
    {
        $rate->fill($request->get('rate'))->save();
//        Rate::create($data);
        return redirect()->route('rates');
        Toast::info('Тарифы успешно изменены');
    }
}
