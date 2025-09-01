<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Receive extends Model
{
    use HasFactory, AsSource, Filterable, Attachable, Chartable;

    protected $fillable = ['user_id', 'sum', 'comment'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
