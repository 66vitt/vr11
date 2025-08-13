<?php

namespace App\Orchid\Screens\Order;

use App\Http\Requests\ConfirmOrderRequest;
use App\Models\Client;
use App\Models\Finance;
use App\Models\Order;
use App\Models\OrderPoint;
use App\Models\Point;
use App\Models\Truck;
use App\Models\User;
use App\View\Components\ImageComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Coords;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ShowOrderScreen extends Screen
{
    public $order;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Order $order): iterable
    {
        return [
            'order' => $order,
            'attachments' => $order->attachments()->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Просмотр заказа';
    }


    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
//            ModalToggle::make('Добавить точку погрузки/выгрузки')
//                ->modal('addLoading')
//                ->method('addLoading')
//                ->type(Color::SUCCESS)
//                ->canSee(Auth::user()->inRole('driver'))
//                ->canSee($this->order->end_time === null),
//            ModalToggle::make('Добавить разгрузку')
//                ->modal('addUploading')
//                ->method('addUploading')
//                ->type(Color::ERROR)
//                ->canSee(Auth::user()->inRole('driver')),
//            Link::make('Завершить заказ')
//                ->type(Color::DANGER)
//                ->route('order.finish', $this->order->id)
//                ->canSee(Auth::user()->id === $this->order->user_id)
//                ->canSee($this->order->end_time === null),
            ModalToggle::make('Подтвердить')
                ->modal('confirm')
                ->method('confirm')
                ->type(Color::DANGER)
                ->canSee($this->order->confirmed == 0 && Auth::user()->inRole('admin')),
            Link::make('Назад')
                ->type(Color::LINK)
                ->route('orders')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $attachments = $this->order->attachments;
        return [
            Layout::legend('order', [
                Sight::make('id'),
                Sight::make('Заказчик')
                    ->render(function(Order $order){
                        return Client::find($order['client_id'])->title;
                    }),
                Sight::make('Водитель')
                    ->render(function(Order $order){
                        return User::find($order['user_id'])->name;
                    })
                    ->canSee($this->order->user_id !== Auth::user()->id),
                Sight::make('Автомобиль')
                    ->render(function(Order $order){
                        return Truck::find($order['truck_id'])->number;
                    }),
                Sight::make('created_at', 'Дата заказа'),
                Sight::make('end_time', 'Завершение заказа'),
                Sight::make('longness', 'Длительность заказа')
                    ->render(function(Order $order){
                        return ceil((strtotime($order['end_time']) - $order['created_at']->timestamp) / 3600) . ' ч.';
                    })
                    ->canSee($this->order->end_time != null),
                Sight::make('start_km', 'Одометр по прибытии на заказ'),
                Sight::make('end_km', 'Одометр по завершении заказа'),
                Sight::make('lengthness', 'Пробег на заказе')
                    ->render(function(Order $order){
                        return $order['end_km'] - $order['start_km'] . ' км.';
                    })
                    ->canSee($this->order->end_km != null),
                Sight::make('Погрузка')
                    ->render(function(Order $order){
                        $str = '';
                        foreach($order->points()->where('type', 'loading')->get() as $item){
                            $str .= $item->address . ', ';
                        };
                        return $str;
                    }),
                Sight::make('Выгрузка')
                    ->render(function(Order $order){
                        $str = '';
                        foreach($order->points()->where('type', 'uploading')->get() as $item){
                            $str .= $item->address . ', ';
                        };
                        return $str;
                    }),

                Sight::make('ot_number', 'Количество погруженных опентопов'),
                Sight::make('self_number', 'Количество погруженных банок 30м3'),
                Sight::make('odd_point_number', 'Дополнительные адреса погрузки/выгрузки'),
                Sight::make('confirmed_sum', 'Стоимость заказа'),
                Sight::make('description', 'Примечание'),
            ]),
//            Layout::component(ImageComponent::class),
            Layout::modal('confirm', Layout::rows([
                TextArea::make('order.description') -> title('Примечание к заказу'),
                Input::make('order.confirmed_sum') ->title('Подтвержденная стоимость')
            ]))->title('Подтверждение стоимости заказа'),
            Layout::modal('addLoading', Layout::rows([
                Select::make('type')
                    ->options([
                        'loading' => 'Погрузка',
                        'uploading' => 'Выгрузка'
                    ]),
                Input::make('address'),
                Coords::make('coords')
            ]))->canSee(Auth::user()->inRole('driver')),
        ];
    }

    public function addLoading(Request $request){
        $data = $request->validate([
            'type' => ['required', 'string'],
            'address' => ['required', 'string'],
            'coords' => ['array:lat,lng'],
        ]);
        $point = Point::firstOrCreate([
            'address' => $data['address'],
            'type' => $data['type']
        ],[
            'address' => $data['address'],
            'lat' => $data['coords']['lat'],
            'lng' => $data['coords']['lng'],
            'type' => $data['type']
        ]);
        OrderPoint::create([
            'order_id' => $this->order->id,
            'point_id' => $point['id']
        ]);
        $data['type'] === 'loading' ? Toast::info('Адрес погрузки добавлен!') : Toast::info('Адрес разгрузки добавлен!');
    }


    public function confirm(Order $order, ConfirmOrderRequest $request){
        $data = $request->get('order');
        $data['confirmed'] = 1;
        $order->fill($data)->save();

        //Добавление данных в таблицу финансов
        $findata['user_id'] = $this->order->user_id;
        $findata['sum'] = $data['confirmed_sum'];
        $findata['order_id'] = $this->order->id;
        $findata['target'] = 1;
        $financeLast = Finance::where('user_id', $this->order->user_id)->orderBy('id', 'desc')->first();
        if($financeLast === null){
            $findata['total'] = $findata['sum'];
        } else {
            $findata['total'] = $financeLast['total'] + $findata['sum'];
        }
        Finance::create($findata);

        Toast::info('Стоимость заказа подтверждена!');
    }
}
