<?php

namespace App\Orchid\Screens\Finance;

use App\Actions\FinanceCreateAction;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ReceiveRequest;
use App\Models\Expense;
use App\Models\Finance;
use App\Models\Receive;
use App\Orchid\Layouts\Finance\ExpensesListTable;
use App\Orchid\Layouts\Finance\ReceivesListTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ExpensesListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'expenses' => auth()->user()->inRole('admin') ?  Expense::all() : auth()->user()->expenses,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список расходов';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить')
                ->modal('spenses')
                ->method('addExpense')
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
            ExpensesListTable::class,
            Layout::modal('spenses', [
                Layout::rows([
                    Input::make('sum')
                        ->title('Сумма')
                        ->help('Введите сумму расходов наличными.')
                        ->required(),
                    TextArea::make('comment')
                        ->title('Примечание'),
                    Attach::make('image_id')
                        ->accept('image/*')
                        ->storage('receipts_images')
                        ->title('Загрузить чек')
                        ->withoutFormType(),
                ]),
            ])->title('Добавить')->async('asyncGetExpense')
        ];
    }

    public function asyncGetExpense(Expense $expense)
    {
        $expense->load('image');
        return [
            'expense' => $expense
        ];
    }

    public function addExpense(ExpenseRequest $request, FinanceCreateAction $action){
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $operation = Expense::create($data);
        $operation['money'] = $data['sum'];

        $action->handle($operation, $target = 4);

        Toast::info('Потраченная сумма добавлена в таблицу');
    }
}
