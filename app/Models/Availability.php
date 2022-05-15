<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'availabilities';
    protected $fillable = [
        'hiden',
        'availability',
        'quantity',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
