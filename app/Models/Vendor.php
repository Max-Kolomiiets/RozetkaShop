<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'vendors';
    protected $fillable = [
        'name', 
        'alias',
        'country_id'
    ];
}
