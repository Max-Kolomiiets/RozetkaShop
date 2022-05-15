<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'prices';
    protected $fillable = [
        'price', 
        'price_old', 
        'price_promo',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}