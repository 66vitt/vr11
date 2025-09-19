<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Finance;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
//            Menu::make('Get Started')
//                ->icon('bs.book')
//                ->title('Navigation')
//                ->route(config('platform.index')),

            Menu::make('Клиенты')
                ->icon('bs.person-lines-fill')
                ->title('Navigation')
                ->route('clients')
                ->permission('client_list'),

            Menu::make('Автотранспорт')
                ->icon('bs.truck')
                ->route('trucks')
                ->permission('truck_list'),

            Menu::make('Тарифы для водителей')
                ->icon('bs.currency-exchange')
                ->route('rates')
                ->permission('current_rate'),

            Menu::make('Заказы')
                ->icon('bs.telephone-forward')
                ->route('orders')
                ->permission('order_list')
                ->badge(function(){
                    if(Auth::user()->inRole('admin') && Order::where('confirmed', 0)->count() != 0){
                        return Order::where('confirmed', 0)->count();
                    }
                }),

            Menu::make('Общая таблица')
                ->icon('bs.currency-dollar')
                ->route('finances')
                ->title('Финансы')
                ->permission('finance_list')
                ->badge(function(){
                    if(Auth::user()->inRole('admin')){
                        $users = User::all();
                        $sum = 0;
                        foreach($users as $user){
                            if($user->finances->last() != null) {
                                $sum += $user->finances->last()->total;
                            }
                        }
                        return $sum;
                    }
                    $finance = Finance::where('user_id', Auth::user()->id)->defaultSort('created_at', 'desc')->first();
                    if($finance) {
                        return $finance->total;
                    }
                }),

            Menu::make('Получение наличных')
                ->icon('bs.plus-square')
                ->route('receives')
                ->permission('receives_list'),

            Menu::make('Расходы')
                ->icon('bs.dash-square')
                ->route('expenses')
                ->permission('expenses_list'),

            Menu::make('Статистика')
                ->icon('bs.bar-chart-line')
                ->title('Статистика')
                ->route('reports')
                ->permission('statistics'),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('Клиенты'))
                ->addPermission('client_list', __('Список клиентов'))
                ->addPermission('client_add', __('Добавление и изменение клиентов')),
            ItemPermission::group(__('Финансы'))
                ->addPermission('expenses_list', 'Расходы')
                ->addPermission('finance_list', 'Общий список')
                ->addPermission('receives_list', 'Поступления')
                ->addPermission('show_expense', 'Детали'),
            ItemPermission::group(__('Заказы'))
                ->addPermission('order_list', 'Список')
                ->addPermission('start_order', 'Начало')
                ->addPermission('current_order', 'Текущий')
                ->addPermission('finish_order', 'Завершение')
                ->addPermission('show_order', 'Просмотр'),
            ItemPermission::group(__('Тарифы'))
                ->addPermission('current_rate', 'Текущие тарифы')
                ->addPermission('edit_rate', 'Редактирование тарифов'),
            ItemPermission::group('Статистика')
                ->addPermission('statistics', 'Статистика'),
            ItemPermission::group('Транспорт')
                ->addPermission('truck_list', 'Список')
                ->addPermission('truck_show', 'Просмотр')
                ->addPermission('truck_edit', 'Правка'),
        ];
    }
}
