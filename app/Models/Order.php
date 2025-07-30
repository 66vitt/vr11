<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use HasFactory, AsSource, Filterable, Attachable, SoftDeletes;

    protected $fillable =
        [
            'start_km',
            'end_km',
            'end_time',
            'ot_number',
            'self_number',
            'odd_point_number',
            'user_id',
            'client_id',
            'truck_id',
            'sum',
            'confirmed_sum',
            'confirmed',
            'cash',
            'image',
            'description'
        ];
    protected $dates = [
        'end_time',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function points(){
        return $this->belongsToMany(Point::class, 'order_points', 'order_id', 'point_id');
    }
}
