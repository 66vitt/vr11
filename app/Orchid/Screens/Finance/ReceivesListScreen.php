<?php

namespace App\Orchid\Screens\Finance;

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

    public function addReceive(ReceiveRequest $request){
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $receive = Receive::create($data);

        $fincash['user_id'] = $receive['user_id'];
        $fincash['sum'] = $receive['sum'];
        $fincash['receipt_id'] = $receive['id'];
        $fincash['target'] = 3;
        $financeLast = Finance::where('user_id', $receive['user_id'])->orderBy('id', 'desc')->first();
        if($financeLast === null){
            $fincash['total'] = -$fincash['sum'];
        } else {
            $fincash['total'] = $financeLast['total'] - $fincash['sum'];
        }
        Finance::create($fincash);

        Toast::info('Полученная сумма добавлена в таблицу');
    }
}
