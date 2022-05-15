<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'images';
    protected $fillable = [
        'alias',
        'url',
        'alt',
        'title',
        'created_at',
        'product_id'
    ];
}
