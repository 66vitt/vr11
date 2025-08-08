<?php

namespace App\Orchid\Screens\Client;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Orchid\Layouts\Client\ClientListTable;
use App\Orchid\Layouts\Client\CreateOrUpdateClient;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'clients' => Client::filters()->defaultSort('title', 'asc')->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Клиенты';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить клиента')
                ->route('client.create')
                ->class('text-primary')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        setcookie('last_uri', $_SERVER['REQUEST_URI'], 0, '/');
        return [
            ClientListTable::class,
        ];
    }


    public function createOrUpdateClient(ClientRequest $request): void
    {
        $clientId = $request->input('client.id');
        Client::updateOrCreate([
            'id' => $clientId,
        ], $request->validated()['client']);

        is_null($clientId) ? Toast::info('Клиент создан') : Toast::info('Данные обновлены');
    }

}
