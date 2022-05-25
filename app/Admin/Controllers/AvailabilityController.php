<?php

namespace App\Admin\Controllers;

use App\Models\Availability;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AvailabilityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Availability';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Availability());

        $grid->column('id', __('Id'));
        $grid->column('hiden', __('Hiden'));
        $grid->column('availability', __('Availability'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('product_id', __('Product id'));

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
        $show = new Show(Availability::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('hiden', __('Hiden'));
        $show->field('availability', __('Availability'));
        $show->field('quantity', __('Quantity'));
        $show->field('product_id', __('Product id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Availability());

        $form->switch('hiden', __('Hiden'));
        $form->switch('availability', __('Availability'));
        $form->number('quantity', __('Quantity'));
        $form->number('product_id', __('Product id'));

        return $form;
    }
}
