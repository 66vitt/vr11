<?php

namespace App\Orchid\Layouts\Truck;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class TruckShowLayout extends Rows
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
                ->required()
                ->canSee('truck.model'),
            Input::make('truck.number')
                ->title('Гос №')
                ->placeholder('Гос №')
                ->required()
                ->canSee('truck.number'),
            Input::make('truck.color')
                ->title('Цвет')
                ->placeholder('Цвет')
                ->required()
                ->hr(),

            DateTimer::make('truck.service_date')
                ->title('ТО')
                ->format('Y-m-d')
                ->placeholder('ТО')
                ->canSee(!$this->query['truck.service_date'] == null),
            Input::make('truck.to_km')
                ->title('Пробег при то')
                ->placeholder('Пробег при то')
                ->canSee(!$this->query['truck.to_km'] == null),
            Input::make('truck.now_km')
                ->title('Текущий пробег')
                ->placeholder('Текущий пробег')
                ->canSee(!$this->query['truck.now_km'] == null),
            DateTimer::make('truck.assicurazione')
                ->title('ОСАГО')
                ->format('Y-m-d')
                ->placeholder('ОСАГО')
                ->canSee(!$this->query['truck.assicurazione'] == null),
            DateTimer::make('truck.takho_to')
                ->title('Тахограф')
                ->format('Y-m-d')
                ->placeholder('Тахограф')
                ->canSee(!$this->query['truck.takho_to'] == null),
            DateTimer::make('truck.to_date')
                ->title('Техосмотр')
                ->format('Y-m-d')
                ->placeholder('Техосмотр')
                ->hr()
                ->canSee(!$this->query['truck.to_date'] == null),

            Input::make('truck.total_height')
                ->title('Габаритная высота')
                ->placeholder('Габаритная высота')
                ->canSee(!$this->query['truck.total_height'] == null),
            Input::make('truck.body_height')
                ->title('Высота кузова')
                ->placeholder('Высота кузова')
                ->canSee(!$this->query['truck.body_height'] == null),
            Input::make('truck.body_width')
                ->title('Ширина кузова')
                ->placeholder('Ширина кузова')
                ->canSee(!$this->query['truck.body_width'] == null),
            Input::make('truck.body_length')
                ->title('Длина кузова')
                ->placeholder('Длина кузова')
                ->canSee(!$this->query['truck.body_length'] == null),
            Input::make('truck.tonnage')
                ->title('Грузоподьемность')
                ->placeholder('Грузоподьемность')
                ->hr()
                ->canSee(!$this->query['truck.tonnage'] == null),

            Attach::make('truck.attachments')
                ->multiple()
                ->storage('trucks_images')
                ->title('Загрузить изображение')
                ->class('zalupa')
                ->horizontal()
                ->withoutFormType(),
        ];
    }
}
