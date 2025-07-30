<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'lat',
        'lng',
        'type'
    ];
    public function orders(){
        return $this->belongsToMany(Order::class, 'order_points', 'point_id', 'order_id');
    }
}
