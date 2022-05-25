<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = [
        'alias',
        'url',
        'alt',
        'title',
        'created_at',
        'product_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
