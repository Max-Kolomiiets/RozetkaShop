<?php

namespace App\Admin\Controllers;

use App\Models\Attribute;
use App\Models\Characteristic;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CharacteristicsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Characteristic';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Characteristic());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('product_id', __('Product id'))->sortable();
        $grid->column('attribute_id', __('Attribute id'))->sortable();
        $grid->column('value', __('Value'))->sortable();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Characteristic::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('product_id', __('Product id'));
        $show->field('attribute_id', __('Attribute id'));
        $show->field('value', __('Value'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Characteristic());

        $form->select('attribute_id', 'Attribute')->options(Attribute::all()->pluck('name','id'));
        $form->select('product_id', 'Product')->options(Product::all()->pluck('name','id'));
        $form->text('value', __('Value'));

        return $form;
    }
}
