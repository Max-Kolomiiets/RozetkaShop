<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guaranty extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'guaranties';
    protected $fillable = [
        'term',
        'description',
        'url',
        'vendor_id',
        'product_id'
    ];
}
