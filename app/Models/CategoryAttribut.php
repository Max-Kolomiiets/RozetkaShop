<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttribut extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'categories_attributes';
    protected $fillable = [
        'category_id', 
        'attribut_id'
    ];
}
