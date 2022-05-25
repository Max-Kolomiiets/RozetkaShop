<?php
//php artisan make:model Country -f
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $fillable = [
        'name', 
        'alias'
    ];

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
}
