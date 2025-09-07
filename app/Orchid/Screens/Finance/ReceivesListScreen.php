<?php

namespace App\Orchid\Screens\Finance;

use App\Actions\FinanceCreateAction;
use App\Http\Requests\ReceiveRequest;
use App\Models\Finance;
use App\Models\Receive;
use App\Orchid\Layouts\Finance\ReceivesListTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReceivesListScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'receives_list'
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
            'receives' => auth()->user()->inRole('admin') ?  Receive::all() : auth()->user()->receives,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список полученых сумм';
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
                ->modal('incasso')
                ->method('addReceive')
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
            ReceivesListTable::class,
            Layout::modal('incasso', [
                Layout::rows([
                    Input::make('sum')
                        ->title('Сумма')
                        ->help('Введите сумму полученную наличными или еще как-нибудь.')
                        ->required(),
                    TextArea::make('comment')
                        ->title('Примечание'),
                ]),
            ])->title('Добавить')
        ];
    }

    public function addReceive(ReceiveRequest $request, FinanceCreateAction $action){
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $operation = Receive::create($data);
        $operation['money'] = $data['sum'];

        $action->handle($operation, $target = 3);


        Toast::info('Полученная сумма добавлена в таблицу');
    }
}
