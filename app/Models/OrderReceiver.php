<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReceiver extends Model
{
    use HasFactory;

    protected $table = 'order_receivers';
    protected $fillable = [
        'name', 
        'lastname',
        'patronymic',
        'phone'
    ];
}
