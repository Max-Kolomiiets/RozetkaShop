<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    use HasFactory;

    protected $fillable = ['alias', 'name'];
    public $timestamps = false;

    public function orderDelivery() {
        return $this->hasMany(OrderDelivery::class);
    }
}
