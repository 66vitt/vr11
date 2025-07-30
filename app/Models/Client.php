<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Client extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = ['title', 'contact', 'address', 'phone'];

    protected $allowedSorts = [
        'title',
        'address',
        'contact'
    ];

    protected $allowedFilters = [
        'title' => Like::class
    ];
}
