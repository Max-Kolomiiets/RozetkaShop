<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['alias', 'status'];
    public $timestamps = false;

    public function orders() {
        $this->hasMany(Order::class); 
    }
}
