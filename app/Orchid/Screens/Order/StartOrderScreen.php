<?php

namespace App\Orchid\Screens\Order;

use App\Http\Requests\StartOrderRequest;
use App\Models\Order;
use App\Orchid\Layouts\Order\StartOrderLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class StartOrderScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'start_order'
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
            'order_last' => Order::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->order->exists ? 'Завершение заказа' : 'Новый заказ';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Начать')
                ->icon('pencil')
                ->type(Color::PRIMARY)
                ->method('createOrUpdate')
                ->canSee(!$this->order->exists),

            Button::make('Update')
                ->icon('note')
                ->type(Color::PRIMARY)
                ->method('createOrUpdate')
                ->canSee($this->order->exists),
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
            StartOrderLayout::class,
        ];
    }

    public function createOrUpdate(StartOrderRequest $request)
    {
        $data = $request->get('order');

        $data['user_id'] = auth()->user()->id;

        $this->order->fill($data)->save();

        Toast::info('Началось выполнение заказа.');

        return redirect()->route('current_order', $this->order->id);
    }


}
