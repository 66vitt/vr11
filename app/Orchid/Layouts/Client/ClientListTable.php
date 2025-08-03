<?php

namespace App\Orchid\Layouts\Client;

use App\Models\Client;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClientListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'clients';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('title', 'Название')->sort()->filter(TD::FILTER_TEXT),
            TD::make('address', 'Адрес')->sort(),
            TD::make('contact', 'Контактное лицо')->sort(),
            TD::make('phone', 'Контактный телефон'),
            TD::make('created_at', 'Дата создания'),
            TD::make('Действия')->render(function(Client $client){
                return Link::make('Редактировать')
                    ->route('client.edit', $client->id)
                    ->class('text-primary');
            })->alignRight(),
        ];
    }
}
