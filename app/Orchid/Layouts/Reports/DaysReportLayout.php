<?php

namespace App\Orchid\Layouts\Reports;

use Orchid\Screen\Layouts\Chart;

class DaysReportLayout extends Chart
{
    protected $title = 'Статистика за последние 30 дней';
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'bar';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;

    protected $target = 'dailyReport';
}
