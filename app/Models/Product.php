<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'products';
    protected $fillable = [
        'name', 
        'alias',
        'vendor_id',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function characteristics()
    {
        return $this->hasMany(Characteristic::class);
    }

    public function images()
    {
        return $this->hasMany(Characteristic::class);
    }

    public function price()
    {
        return $this->hasOne(Price::class);
    }

    public function availability()
    {
        return $this->hasOne(Availability::class);
    }

    public function description()
    {
        return $this->hasOne(Description::class);
    }

    public function guaranty()
    {
        return $this->hasOne(Guaranty::class);
    }
}
