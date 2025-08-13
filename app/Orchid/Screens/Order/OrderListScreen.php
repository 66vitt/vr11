<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Orchid\Layouts\Order\OrderListTable;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class OrderListScreen extends Screen
{
    public $currentOrder;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'orders' => Order::where('sum', '!=', 'null')->filters()->defaultSort('created_at', 'desc')->paginate(20),
            'currentOrder' => Order::where('sum', null)->where('user_id', Auth::user()->id)->first(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Заказы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        if($this->currentOrder === null){
            return [
                Link::make('Начать заказ')
                    ->icon('pencil')
                    ->type(Color::PRIMARY)
                    ->route('order.start')
                    ->canSee(Auth::user()->roles->count() !== 0 && Auth::user()->roles[0]->slug === 'driver'),
            ];
        } else {
            return [
                Link::make('На заказе')
                    ->canSee(Auth::user()->roles[0]->slug === 'driver' && $this->currentOrder !== null)
                    ->icon('pencil')
                    ->type(Color::WARNING)
                    ->route('current_order', $this->currentOrder->id, false),
            ];
        }
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            OrderListTable::class,
        ];
    }
}
