<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeeklyReportTable extends Component
{
    public $weeklyReport;
    /**
     * Create a new component instance.
     */
    public function __construct($weeklyReport)
    {
        $this->weeklyReport = $weeklyReport;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.weekly-report-table');
    }
}
