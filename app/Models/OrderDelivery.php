<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;

    protected $fillable = ['delivery_method_id', 'alias', 'name'];
    public $timestamps = false;

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }
}
