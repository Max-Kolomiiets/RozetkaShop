<?php

namespace App\Admin\Selectable;

use App\Models\Product;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Grid\Selectable;

class Products extends Selectable
{
    public $model = Product::class;

    public function make()
    {
        $this->column('id')->sortable();
        $this->column('name')->sortable();
        $this->column('alias');
        $this->column('category.name');
        $this->column('vendor.name');

        $this->filter(function (Filter $filter) {
            $filter->like('name');
        });


        // $grid->column('id', __('Id'))->sortable();
        // $grid->column('name', __('Name'))->sortable();
        // $grid->column('alias', __('Alias'));

        // $grid->category()->name();
        // $grid->vendor()->name();
    }
}