<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereIn;
use Orchid\Filters\Types\WhereMaxMin;
use Orchid\Screen\AsSource;

class Finance extends Model
{
    use HasFactory, AsSource, SoftDeletes, Attachable, Filterable;

    protected $fillable = ['user_id', 'sum', 'order_id', 'expense_id', 'receipt_id', 'target', 'total'];

    public const TARGET = [
        '1' => 'З/п за выполненный заказ',
        '2' => 'Получение наличной оплаты за заказ',
        '3' => 'Получение з/п в кассе',
        '4' => 'Дорожные расходы, нал.'
    ];

    protected $allowedFilters = [
        'user_id' => WhereIn::class,
        'id' => Where::class,
        'target' => Like::class,
        'created_at' => WhereMaxMin::class
    ];

    protected $allowedSorts = [
        'id',
        'user_id',
        'target',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
    public function order(){
        return $this->hasOne(Order::class);
    }
}
