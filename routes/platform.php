<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/dashboard', PlatformScreen::class)
    ->name('platform.main')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->push('', route('platform.main')));

// Clients
Route::screen('/clients', \App\Orchid\Screens\Client\ClientListScreen::class)
    ->name('clients')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Клиенты', route('clients')));
Route::screen('/client/create', \App\Orchid\Screens\Client\ClientCreateScreen::class)
    ->name('client.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('clients')
        ->push('Добавить клиента'));
Route::screen('/client/{client}/edit', \App\Orchid\Screens\Client\ClientCreateScreen::class)
    ->name('client.edit')
    ->breadcrumbs(fn(Trail $trail, $client) => $trail
        ->parent('clients')
        ->push($client->title));

//транспорт
Route::screen('/trucks', \App\Orchid\Screens\Truck\TruckListScreen::class)
    ->name('trucks')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Автотранспорт', route('trucks')));
Route::screen('truck/create', \App\Orchid\Screens\Truck\TruckEditScreen::class)
    ->name('trucks.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('trucks')
        ->push('Добавить'));
Route::screen('truck/{truck}', \App\Orchid\Screens\Truck\TruckShowScreen::class)
    ->name('trucks.show')
    ->breadcrumbs(fn(Trail $trail, $truck) => $trail
        ->parent('trucks')
        ->push($truck->number));
Route::screen('truck/{truck}/edit', \App\Orchid\Screens\Truck\TruckEditScreen::class)
    ->name('trucks.edit')
    ->breadcrumbs(fn(Trail $trail, $truck) => $trail
        ->parent('trucks')
        ->push($truck->number));

//Тарифы
Route::screen('rates', \App\Orchid\Screens\Rate\CurrentRateScreen::class)
    ->name('rates')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Тарифы для водителей', route('rates')));
Route::screen('rates.edit', \App\Orchid\Screens\Rate\EditRateScreen::class)
    ->name('rates.edit')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('rates')
        ->push('Редактирование тарифов'));


//Заказы
Route::screen('orders', \App\Orchid\Screens\Order\OrderListScreen::class)
    ->name('orders')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Заказы', route('orders')));
Route::screen('order/start', \App\Orchid\Screens\Order\StartOrderScreen::class)
    ->name('order.start')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Новый заказ', route('order.start')));
Route::screen('order/{order?}/finish', \App\Orchid\Screens\Order\FinishOrderScreen::class)
    ->name('order.finish')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Завершение заказа', route('order.finish')));
Route::screen('order/{order?}', \App\Orchid\Screens\Order\ShowOrderScreen::class)
    ->name('order.show')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('orders')
        ->push('Просмотр заказа', route('order.show')));
Route::screen('current_order/{order?}', \App\Orchid\Screens\Order\CurrentOrderScreen::class)
    ->name('current_order')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('orders')
        ->push('Выполнение заказа', route('current_order')));

//Финансы
Route::screen('finances', \App\Orchid\Screens\Finance\FinanceListScreen::class)
    ->name('finances')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Финансы', route('finances')));
Route::screen('receives', \App\Orchid\Screens\Finance\ReceivesListScreen::class)
    ->name('receives')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('finances')
        ->push('Получение', route('receives')));
Route::screen('expenses', \App\Orchid\Screens\Finance\ExpensesListScreen::class)
    ->name('expenses')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('finances')
        ->push('Расходы', route('expenses')));
Route::screen('expense/{expense?}', \App\Orchid\Screens\Finance\ShowExpenseScreen::class)
    ->name('expense.show')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('expenses')
        ->push('Просмотр наличного расхода', route('expense.show')));

//Статистика
Route::screen('reports', \App\Orchid\Screens\Statistics\ReportsScreen::class)
    ->name('reports')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Статистика', route('reports')));






// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.main')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.main')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.main')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.main')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

// Route::screen('idea', Idea::class, 'platform.screens.idea');
