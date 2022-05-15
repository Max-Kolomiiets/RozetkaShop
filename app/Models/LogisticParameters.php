<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticParameters extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'logistic_parameters';
    protected $fillable = [
        'packing_weight', 
        'packing_height', 
        'packing_width', 
        'packing_depth', 
        'packages_quantity'
    ];
}
