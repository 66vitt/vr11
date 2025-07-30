<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Truck extends Model
{
    use HasFactory, SoftDeletes, AsSource, Filterable, Attachable;

    protected $fillable = [
        'model',
        'number',
        'color',
        'assicurazione',
        'takho_to',
        'to_date',
        'service_date',
        'to_km',
        'now_km',
        'total_height',
        'body_height',
        'body_width',
        'body_length',
        'tonnage',
        'image_id'
    ];

    protected $allowedSorts = [
        'number',
    ];
    protected $allowedFilters = [
        'number' => Like::class,
    ];
}
