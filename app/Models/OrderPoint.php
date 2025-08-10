<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPoint extends Model
{
    protected $fillable = [
        'order_id',
        'point_id'
    ];
}
