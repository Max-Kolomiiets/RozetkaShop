<?php

namespace App\Admin\Selectable;

use App\Models\Attribute;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Grid\Selectable;

class Attributes extends Selectable
{
    public $model = Attribute::class;

    public function make()
    {
        $this->column('id');
        $this->column('name');
        $this->column('alias');
        $this->column('value_type',);
        $this->column('filter');
        $this->column('required');

        $this->filter(function (Filter $filter) {
            $filter->like('name');
        });
    }
}