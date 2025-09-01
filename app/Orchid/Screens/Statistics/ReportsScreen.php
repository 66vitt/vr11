<?php

namespace App\Orchid\Screens\Statistics;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Receive;
use App\Orchid\Layouts\Reports\DaysReportLayout;
use App\Orchid\Layouts\Reports\MonthsReportLayout;
use App\Orchid\Layouts\Reports\ReportsOrders;
use App\Orchid\Layouts\Reports\WeeksReportLayout;
use App\View\Components\MonthlyReportTable;
use App\View\Components\ReportTable;
use App\View\Components\WeeklyReportTable;
use App\View\Components\ZalupaComponent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ReportsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $selectedUser = 4;
        if(Auth::user()->roles[0]->slug === 'admin'){
            return [
                'dailyReport' => [
                    Order::countByDays()->toChart('Количество заказов'),
                    Order::sumByDays('sum')->toChart('Зарплата'),
                    Expense::sumByDays('sum')->toChart('Расходы'),
                    Receive::sumByDays('sum')->toChart('Полученная сумма'),
                ],
                'weeklyReport' => [
                    Order::countByWeeks()->toChart('Количество заказов'),
                    Order::sumByWeeks('sum')->toChart('Зарплата'),
                    Expense::sumByWeeks('sum')->toChart('Расходы'),
                    Receive::sumByWeeks('sum')->toChart('Полученная сумма'),
                ],
                'monthlyReport' => [
                    Order::countByMonths()->toChart('Количество заказов'),
                    Order::sumByMonths('sum')->toChart('Зарплата'),
                    Expense::sumByMonths('sum')->toChart('Расходы'),
                    Receive::sumByMonths('sum')->toChart('Полученная сумма'),
                ]
            ];
        };
        return [
            'dailyReport' => [
                Order::where('user_id', Auth::user()->id)->countByDays()->toChart('Количество заказов'),
                Order::where('user_id', Auth::user()->id)->sumByDays('sum')->toChart('Зарплата'),
                Expense::where('user_id', Auth::user()->id)->sumByDays('sum')->toChart('Расходы'),
                Receive::where('user_id', Auth::user()->id)->sumByDays('sum')->toChart('Полученная сумма'),
            ],
            'weeklyReport' => [
                Order::where('user_id', Auth::user()->id)->countByWeeks()->toChart('Количество заказов'),
                Order::where('user_id', Auth::user()->id)->sumByWeeks('sum')->toChart('Зарплата'),
                Expense::where('user_id', Auth::user()->id)->sumByWeeks('sum')->toChart('Расходы'),
                Receive::where('user_id', Auth::user()->id)->sumByWeeks('sum')->toChart('Полученная сумма'),
            ],
            'monthlyReport' => [
                Order::where('user_id', Auth::user()->id)->countByMonths()->toChart('Количество заказов'),
                Order::where('user_id', Auth::user()->id)->sumByMonths('sum')->toChart('Зарплата'),
                Expense::where('user_id', Auth::user()->id)->sumByMonths('sum')->toChart('Расходы'),
                Receive::where('user_id', Auth::user()->id)->sumByMonths('sum')->toChart('Полученная сумма'),
            ]
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Статистика';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            DaysReportLayout::class,
            Layout::component(ReportTable::class),
            WeeksReportLayout::class,
            Layout::component(WeeklyReportTable::class),
            MonthsReportLayout::class,
            Layout::component(MonthlyReportTable::class),
        ];
    }
}
