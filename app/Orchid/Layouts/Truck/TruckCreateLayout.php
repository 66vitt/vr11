<?php

namespace App\Orchid\Layouts\Truck;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class TruckCreateLayout extends Rows
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
            Input::make('truck.model')
                ->title('Модель автомобиля')
                ->placeholder('Модель автомобиля')
                ->required(),
            Input::make('truck.number')
                ->title('Гос №')
                ->placeholder('Гос №')
                ->required(),
            Input::make('truck.color')
                ->title('Цвет')
                ->placeholder('Цвет')
                ->required()
                ->hr(),

            DateTimer::make('truck.service_date')
                ->title('ТО')
                ->format('Y-m-d')
                ->placeholder('ТО'),
            Input::make('truck.to_km')
                ->title('Пробег при то')
                ->placeholder('Пробег при то'),
            Input::make('truck.now_km')
                ->title('Текущий пробег')
                ->placeholder('Текущий пробег'),
            DateTimer::make('truck.assicurazione')
                ->title('ОСАГО')
                ->format('Y-m-d')
                ->placeholder('ОСАГО'),
            DateTimer::make('truck.takho_to')
                ->title('Тахограф')
                ->format('Y-m-d')
                ->placeholder('Тахограф'),
            DateTimer::make('truck.to_date')
                ->title('Техосмотр')
                ->format('Y-m-d')
                ->placeholder('Техосмотр')
                ->hr(),

            Input::make('truck.total_height')
                ->title('Габаритная высота')
                ->placeholder('Габаритная высота'),
            Input::make('truck.body_height')
                ->title('Высота кузова')
                ->placeholder('Высота кузова'),
            Input::make('truck.body_width')
                ->title('Ширина кузова')
                ->placeholder('Ширина кузова'),
            Input::make('truck.body_length')
                ->title('Длина кузова')
                ->placeholder('Длина кузова'),
            Input::make('truck.tonnage')
                ->title('Грузоподьемность')
                ->placeholder('Грузоподьемность')
                ->hr(),

            Attach::make('truck.attachments')
                ->multiple()
                ->storage('trucks_images')
                ->title('Загрузить изображение')
                ->horizontal()
                ->withoutFormType(),
        ];
    }
}
