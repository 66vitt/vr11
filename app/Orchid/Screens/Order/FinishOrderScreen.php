<?php

namespace App\Orchid\Screens\Order;

use App\Actions\FinanceCreateAction;
use App\Http\Requests\FinishOrderRequest;
use App\Http\Requests\StartOrderRequest;
use App\Models\Finance;
use App\Models\Order;
use App\Models\Rate;
use App\Orchid\Layouts\Order\FinishOrderLayout;
use App\Orchid\Layouts\Order\StartOrderLayout;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;

class FinishOrderScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'finish_order'
        ];
    }
    public $order;
    public $order_last;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Order $order): iterable
    {
        return [
            'order' => $order,
            'order_last' => Order::where('user_id', auth()->user()->id)->orderBy('created_at')->first(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Завершение заказа!';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Завершить')
                ->icon('pencil')
                ->type(Color::PRIMARY)
                ->method('createOrUpdate'),
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
            FinishOrderLayout::class,
        ];
    }

    public function createOrUpdate(FinishOrderRequest $request, FinanceCreateAction $action)
    {
//        dd($request->all());
        //Добавление данных в таблицу заказов
        $data = $request->get('order');
        $data['end_time'] = Carbon::now();

        $rate = Rate::orderBy('created_at', 'desc')->first();
        $sum = 0;
        $hours_norm = $rate['city_limit_time'];
        $distance = $data['end_km'] - $this->order['start_km'];
        if($distance <= 50){
            $sum += $rate['city'];
        } elseif ($distance > 50 && $distance <= 100){
            $sum += $rate['region100'];
            $hours_norm += 1;
        } elseif ($distance > 100 && $distance <= 150){
            $sum += $rate['region150'];
            $hours_norm += 2;
        } elseif ($distance > 150 && $distance <= 200){
            $sum += $rate['region200'];
            $hours_norm += 3;
        } elseif ($distance > 200){
            $sum += $rate['region250'];
            $hours_norm += 4;
        }

        $longness = ceil(($data['end_time']->timestamp - $this->order['created_at']->timestamp) / 3600);
        if($longness > $hours_norm){
            $sum += ($longness - $hours_norm) * $rate['odd_hours_cost'];
        }

        $sum += $data['ot_number'] * $rate['ot_cost'];

        $sum += $data['self_number'] * $rate['self_cost'];

        $points_count = $this->order->points->count();

        if($points_count === 0 || $points_count === 1 || $points_count === 2){
            $data['odd_point_number'] = 0;
        } else{
            $data['odd_point_number'] = $points_count - 2;
        }

        $sum += $data['odd_point_number'] * $rate['odd_point_cost'];

        $data['sum'] = $sum;
        $data['confirmed_sum'] = $data['sum'];



        $this->order->fill($data)->save();
        $this->order->attachments()->syncWithoutDetaching(
            $request->input('order.attachments', [])
        );
        $operation = $this->order;

        if($data['cash'] != 0){
            $operation['money'] = $data['cash'];
            $action->handle($operation, $target = 2);
        }

        Toast::info('Заказ успешно завершен.');

        return redirect()->route('orders');
    }
}
