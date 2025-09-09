<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait Chartable
{
    /**
     * Counts the values for model at the range and previous range.
     */
    public function scopeCountForGroup(Builder $builder, string $groupColumn): GroupCollection
    {
        $group = $builder->select("$groupColumn as label", DB::raw('count(*) as value'))
            ->groupBy($groupColumn)
            ->orderBy('value', 'desc')
            ->get()
            ->map(fn (Model $model) => $model->forceFill([
                'label' => (string) $model->label,
                'value' => (int) $model->value,
            ]));

        return new GroupCollection($group);
    }

    /**
     * @param mixed|null $startDate
     * @param mixed|null $stopDate
     * @param string     $dateColumn
     */
    private function groupByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        $dateColumn ??= $builder->getModel()->getCreatedAtColumn();

        $startDate = empty($startDate)
            ? Carbon::now()->subMonth()
            : Carbon::parse($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()
            : Carbon::parse($stopDate);

        $query = $builder
            ->select(DB::raw("$value as value, DATE($dateColumn) as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();


        $days = $startDate->diffInDays($stopDate) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->toDateString()
            );

            $result = [
                'value'   => ($found ? $found->value : 0),
                'label'   => $startDate->toDateString(),
            ];

            $startDate->addDay();

            return $result;
        });
    }

    private function groupByWeeks(Builder $builder, string $value, $startWeek = null, $stopWeek = null, ?string $dateColumn = null): TimeCollection
    {
        $dateColumn ??= $builder->getModel()->getCreatedAtColumn();

        $startWeek = empty($startWeek)
            ? Carbon::now()->subWeeks(10)
            : Carbon::parse($startWeek);
//        dd($startWeek);

        $stopWeek = empty($stopWeek)
            ? Carbon::now()
            : Carbon::parse($stopWeek);

        $query = $builder
            ->select(DB::raw("$value as value, WEEK($dateColumn) as label"))
            ->whereBetween($dateColumn, [$startWeek, $stopWeek])
            ->groupBy('label')
            ->orderBy('label')
            ->get();



        $weeks = $startWeek->diffInWeeks($stopWeek) + 1;


        return TimeCollection::times($weeks, function () use ($startWeek, $query) {
            $found = $query->firstWhere(
                'label',
                $startWeek->weekOfYear()-1
            );


            $result = [
                'value'   => ($found ? $found->value : 0),
                'label'   => $startWeek->format('W'),
            ];

            $startWeek->addWeek();

            return $result;
        });
    }

    private function groupByMonths(Builder $builder, string $value, $startMonth = null, $stopMonth = null, ?string $dateColumn = null): TimeCollection
    {
        $dateColumn ??= $builder->getModel()->getCreatedAtColumn();

        $startMonth = empty($startMonth)
            ? Carbon::create(null, 1, 1)
            : Carbon::parse($startMonth);

        $stopMonth = empty($stopMonth)
            ? Carbon::create(null, 12, 31, 23, 59)
            : Carbon::parse($stopMonth);

        $query = $builder
            ->select(DB::raw("$value as value, MONTH($dateColumn) as label"))
            ->whereBetween($dateColumn, [$startMonth, $stopMonth])
            ->groupBy('label')
            ->orderBy('label')
            ->get();



        $months = $startMonth->diffInMonths($stopMonth) + 1;


        return TimeCollection::times($months, function () use ($startMonth, $query) {
            $found = $query->firstWhere(
                'label',
                $startMonth->monthOfYear()
            );


            $result = [
                'value'   => ($found ? $found->value : 0),
                'label'   => $startMonth->format('m'),
            ];

            $startMonth->addMonth();

            return $result;
        });
    }

    /**
     * Get total models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string                        $dateColumn
     */
    public function scopeCountByDays(Builder $builder, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, 'count(*)', $startDate, $stopDate, $dateColumn);
    }

    public function scopeCountByWeeks(Builder $builder, $startWeek = null, $stopWeek = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByWeeks($builder, 'count(*)', $startWeek, $stopWeek, $dateColumn);
    }

    public function scopeCountByMonths(Builder $builder, $startMonth = null, $stopMonth = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths($builder, 'count(*)', $startMonth, $stopMonth, $dateColumn);
    }

    /**
     * Get average models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    public function scopeAverageByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "avg($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    public function scopeSumByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByWeeks(Builder $builder, string $value, $startWeek = null, $stopWeek = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByWeeks($builder, "sum($value)", $startWeek, $stopWeek, $dateColumn);
    }

    public function scopeSumByMonths(Builder $builder, string $value, $startMonth = null, $stopMonth = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths($builder, "sum($value)", $startMonth, $stopMonth, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    public function scopeMaxByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "max($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get min models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    public function scopeMinByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "min($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * @deprecated usage maxByDays or minByDays
     *
     * Get values models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    public function scopeValuesByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        return $this->groupByDays($builder, $value, $startDate, $stopDate, $dateColumn);
    }
}
