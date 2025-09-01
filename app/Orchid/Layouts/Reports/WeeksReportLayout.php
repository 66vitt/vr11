<?php

namespace App\Orchid\Layouts\Reports;

use Orchid\Screen\Layouts\Chart;

class WeeksReportLayout extends Chart
{
    protected $title = 'Статистика за последние 10 недель';
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

    protected $target = 'weeklyReport';
}
