<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guaranty extends Model
{
    use HasFactory;
    protected $table = 'guaranties';
    protected $fillable = [
        'term',
        'description',
        'url',
        'vendor_id',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
