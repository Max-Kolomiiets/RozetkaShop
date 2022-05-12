<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'descriptions';
    protected $fillable = [
        'state',
        'ean',
        'description',
        'added_at',
        'product_id',
        'country_id',
        'logistic_parameters_id'
    ];
}
