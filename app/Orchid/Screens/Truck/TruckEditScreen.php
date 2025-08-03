<?php

namespace App\Orchid\Screens\Truck;

use App\Http\Requests\TruckRequest;
use App\Models\Truck;
use App\Orchid\Layouts\Truck\ImageDataTruck;
use App\Orchid\Layouts\Truck\RegistrationDataTruck;
use App\Orchid\Layouts\Truck\ServiceDataTruck;
use App\Orchid\Layouts\Truck\SizeDataTruck;
use App\Orchid\Layouts\Truck\TruckCreateLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class TruckEditScreen extends Screen
{
    public $truck;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Truck $truck): iterable
    {
        $truck->load('attachments');
        return [
            'truck' => $truck,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->truck->exists ? 'Редактирование автомобиля' : 'Добавление нового автомобиля';
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
                ->icon('bs.arrow-left-circle')
                ->route(!$this->truck->exists ? 'trucks' : 'trucks.show', $this->truck->id)
                ->type(Color::WARNING),
            Button::make('Добавить')
                ->icon('pencil')
                ->method('createOrUpdateTruck')
                ->type(Color::PRIMARY)
                ->canSee(!$this->truck->exists),
            Button::make('Сохранить')
                ->icon('bs.journal-arrow-down')
                ->method('createOrUpdateTruck')
                ->type(Color::INFO)
                ->canSee($this->truck->exists),
            Button::make('Удалить')
                ->icon('trash')
                ->method('delete')
                ->type(Color::DANGER)
                ->canSee($this->truck->exists)
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
            TruckCreateLayout::class,
        ];
    }

    public function createOrUpdateTruck(Truck $truck, TruckRequest $request)
    {
        $truck->fill($request->get('truck'))->save();
        $truck->attachments()->syncWithoutDetaching(
            $request->input('truck.attachments', [])
        );
        !$this->truck->exists ? Toast::info('Автомобиль успешно добавлен!') : Toast::info('Изменения сохранены');
        return redirect()->route('trucks');
    }

    public function delete(Truck $truck)
    {
        $truck->delete();
        Toast::info('Автомобиль успешно удален!');
        return redirect()->route('trucks');
    }
}
