<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_method_id', 'alias', 'name'];
    public $timestamps = false;

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMehod::class);
    }
}
