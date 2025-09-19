<?php

namespace App\Orchid\Layouts\Finance;

use App\Models\Finance;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FinanceListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'finances';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', '№ п/п')->sort(),
            TD::make('created_at', 'Дата'),
            TD::make('sum', 'Сумма')->sort(),
            TD::make('motivo', 'Основание')
                ->render(function(Finance $finance){
                    if($finance->order_id !== NULL){
                        return Link::make(Finance::TARGET[$finance->target] . ' №' . $finance->order_id)->route('order.show', $finance->order_id);
                    } elseif ($finance->expense_id !== NULL){
                        return Link::make('Расход №' . $finance->expense_id)->route('expense.show', $finance->expense_id);
                    } elseif ($finance->receipt_id !== NULL){
                        return Link::make('Получение №' . $finance->receipt_id)->route('receives');
                    }
                }),
            TD::make('total', 'К выплате')
        ];
    }
}
