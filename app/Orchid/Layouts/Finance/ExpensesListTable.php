<?php

namespace App\Orchid\Layouts\Finance;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Receive;
use App\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ExpensesListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'expenses';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
//        dd(Order::find(2)->user);
        return [
            TD::make( 'Пользователь')
                ->render(function(Expense $expense){
                    return $expense->user->name;
                })->canSee(auth()->user()->inRole('admin')),
            TD::make('sum', 'сумма')
                ->render(function(Expense $expense){
                    return Link::make($expense->sum)->route('expense.show', $expense->id)->class('link-primary');
                }),
            TD::make('comment', 'Примечание'),
            TD::make('created_at', 'Дата')
        ];
    }
}
