<?php

namespace App\Orchid\Layouts\Order;

use App\Models\Client;
use App\Models\Order;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\Toggle;
use Orchid\Screen\Components\Cells\Text;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\UTM;
use Orchid\Screen\Fields\ViewField;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use function Termwind\render;

class OrderListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'orders';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('created_at', 'Дата')
                ->render(function(Order $order){
                    return Link::make($order->created_at)->route('order.show', $order->id)->class('link-primary');
                }),
            TD::make('client_id', 'Заказчик')
                ->render(function(Order $order){
                    return Link::make($order->client->title)
                        ->route('clients');
                }),
            TD::make('address_start', 'Адрес погрузки')
                ->render(function(Order $order){
                    if(empty($order->points()->where('type', 'loading')->first()->address)){
                        return 'не указан';
                    }
                    return $order->points()->where('type', 'loading')->first()->address;
                }),
            TD::make('address_end', 'Адрес выгрузки')
                ->render(function(Order $order){
                    if(empty($order->points()->where('type', 'uploading')->get()->last()->address)){
                        return 'не указан';
                    }
                    return $order->points()->where('type', 'uploading')->get()->last()->address;
                }),
            TD::make('Стоимость заказа')
                ->render(function(Order $order){
                    if($order->confirmed_sum > $order->sum){
                        return Link::make($order->confirmed_sum)->class('text-success');
                    } elseif ($order->confirmed_sum < $order->sum){
                        return Link::make($order->confirmed_sum)->class('text-danger');
                    }
                    return Link::make($order->confirmed_sum);
                }),
            TD::make('Действия')
                ->render(function(Order $order) {
                    return $order->confirmed ? '' : '<span class="text-danger">Подтвердите!</span>';
                }),



        ];
    }

}
