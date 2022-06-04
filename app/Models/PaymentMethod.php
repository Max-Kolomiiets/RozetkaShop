<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['alias', 'name'];
    public $timestamps = false;

    public function orderPayment() {
        return $this->hasMany(OrderPayment::class);
    }
}
