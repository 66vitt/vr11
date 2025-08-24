<?php

namespace App\Orchid\Screens\Finance;

use App\Models\Finance;
use App\Orchid\Layouts\Finance\FinanceListTable;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Screen;

class FinanceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        if(Auth::user()->roles[0]->slug === 'admin') {
            return [
                'finances' => Finance::filters()->defaultSort('id', 'desc')->paginate()
            ];
        }
        return [
            'finances' => Finance::where('user_id', Auth::user()->id)->filters()->defaultSort('id', 'desc')->paginate()
        ];

    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Финансы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
//            Link::make('Получение денег')
//                ->route('receives')
//                ->class('btn-primary btn rounded')
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
            FinanceListTable::class,
        ];
    }
}
