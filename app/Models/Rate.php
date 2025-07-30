<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Rate extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $table = 'rates';

    protected $fillable = [
        'city',
        'region100',
        'region150',
        'region200',
        'region250',
        'region300',
        'region350',
        'region400',
        'region450',
        'city_limit_time',
        'hour_cost_over_limit',
        'ot_cost',
        'self_cost',
        'odd_point_cost',
    ];
}
