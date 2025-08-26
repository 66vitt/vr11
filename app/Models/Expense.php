<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Expense extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $fillable = ['user_id', 'sum', 'comment', 'image_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function image(){
        return $this->hasOne(Attachment::class, 'id', 'image_id');
    }
}
