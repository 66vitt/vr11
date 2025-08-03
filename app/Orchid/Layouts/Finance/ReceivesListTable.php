<?php

namespace App\Orchid\Layouts\Finance;

use App\Models\Order;
use App\Models\Receive;
use App\Models\User;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ReceivesListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'receives';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
//        dd(Order::find(2)->user);
        return [
            TD::make( 'Получатель')
                ->render(function(Receive $receive){
                    return $receive->user->name;
                })->canSee(auth()->user()->inRole('admin')),
            TD::make('sum', 'сумма'),
            TD::make('comment', 'Примечание'),
            TD::make('created_at', 'Дата')
        ];
    }
}
