<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    // user_id	address	phone	email
    protected $table = 'contacts';
    protected $fillable = [
        'user_id', 
        'address',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
