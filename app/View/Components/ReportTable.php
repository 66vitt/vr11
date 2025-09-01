<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReportTable extends Component
{
    public $dailyReport;
    /**
     * Create a new component instance.
     */
    public function __construct($dailyReport)
    {
        $this->dailyReport = $dailyReport;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.report-table');
    }
}
