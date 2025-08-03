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
    public $order;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'orders' => Order::where('sum', '!=', 'null')->filters()->defaultSort('created_at', 'desc')->paginate(20),
            'order' => Order::where('sum', null)->first(),
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
        return [
            Link::make('Начать заказ')
                ->icon('pencil')
                ->type(Color::PRIMARY)
                ->route('order.start')
                ->canSee(Auth::user()->roles[0]->slug === 'driver' && $this->order === null),
//            Link::make('На заказе')
//                ->canSee(Auth::user()->roles[0]->slug === 'driver' && $this->order !== null)
//                ->icon('pencil')
//                ->type(Color::WARNING)
//                ->route('current_order', $this->order->id),

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
            OrderListTable::class,
        ];
    }
}
