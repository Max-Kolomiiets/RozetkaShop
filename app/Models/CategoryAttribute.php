<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    use HasFactory;
    protected $table = 'categories_attributes';
    protected $fillable = [
        'category_id', 
        'attribute_id'
    ];
}
