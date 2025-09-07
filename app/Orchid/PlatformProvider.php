<?php

declare(strict_types=1);

namespace App\Orchid;

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
            Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Navigation')
                ->route(config('platform.index')),

            Menu::make('Клиенты')
                ->icon('bs.person-lines-fill')
                ->title('Navigation')
                ->route('clients'),

            Menu::make('Автотранспорт')
                ->icon('bs.truck')
                ->route('trucks'),

            Menu::make('Тарифы для водителей')
                ->icon('bs.currency-exchange')
                ->route('rates'),

            Menu::make('Заказы')
                ->icon('bs.telephone-forward')
                ->route('orders'),

            Menu::make('Общая таблица')
                ->icon('bs.currency-dollar')
                ->route('finances')
                ->title('Финансы'),
            Menu::make('Получение наличных')
                ->icon('bs.plus-square')
                ->route('receives'),

            Menu::make('Расходы')
                ->icon('bs.dash-square')
                ->route('expenses'),

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
            ItemPermission::group(__('Пользовательская'))
                ->addPermission('statistics', __('Статистика')),
            ItemPermission::group('Транспорт')
                ->addPermission('truck', __('Автотранспорт')),
            ItemPermission::group('Тарифы')
                ->addPermission('rates', __('Тарифы для водителей'))
        ];
    }
}
