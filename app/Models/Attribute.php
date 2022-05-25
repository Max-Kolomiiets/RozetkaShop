<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'attributes';
    protected $fillable = [
        'name',
        'alias',
        'value_type',
        'filter',
        'required'
    ];

    public function products() 
    {
        return $this->belongsToMany(Product::class, 'characteristics');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_attributes');
    }
}
