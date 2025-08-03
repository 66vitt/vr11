<?php

namespace App\Orchid\Screens\Client;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Orchid\Layouts\Client\CreateOrUpdateClient;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class ClientCreateScreen extends Screen
{
    public $client;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Client $client): iterable
    {
        return [
            'client' => $client
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->client->exists ? 'Редактирование клиента ' . $this->client->title : 'Добавление нового клиента';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Назад')
                ->route('clients')
                ->class('text-warning'),
            Button::make('Добавить')
                ->method('createOrUpdateTruck')
                ->class('text-primary')
                ->canSee(!$this->client->exists),
            Button::make('Сохранить')
                ->method('createOrUpdateTruck')
                ->class('text-info')
                ->canSee($this->client->exists),
            Button::make('Удалить')
                ->method('delete')
                ->class('text-danger')
                ->canSee($this->client->exists)
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
            CreateOrUpdateClient::class,
        ];
    }

    public function createOrUpdateTruck(Client $client, ClientRequest $request)
    {
        $client->fill($request->get('client'))->save();
//        $client->attachments()->syncWithoutDetaching(
//            $request->input('client.attachments', [])
//        );
        !$this->client->exists ? Toast::info('Клиент успешно добавлен!') : Toast::info('Изменения сохранены');
        return redirect()->route('clients');
    }
}
