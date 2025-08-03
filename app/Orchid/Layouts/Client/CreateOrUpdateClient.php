<?php

namespace App\Orchid\Layouts\Client;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateClient extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('client.id')
                ->type('hidden'),
            Input::make('client.title')
                ->required()
                ->title('Название'),
            Input::make('client.address')
                ->title('Адрес'),
            Input::make('client.contact')
                ->title('Контактное лицо'),
            Input::make('client.phone')
                ->required()
                ->title('Телефон')
                ->mask('+7(999)999-9999'),
        ];
    }
}
