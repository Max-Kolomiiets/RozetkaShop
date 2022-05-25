<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    use HasFactory;
    protected $table = 'descriptions';
    protected $fillable = [
        'state',
        'ean',
        'description',
        'product_id',
        'country_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
