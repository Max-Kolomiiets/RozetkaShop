<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    
    protected $quarded = [];  
    protected $table = 'categories';
    protected $fillable = [
        'parent_id',
        'name', 
        'alias'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
                    ->orderBy('name','asc');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function category_attributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'categories_attributes');
    }
}
