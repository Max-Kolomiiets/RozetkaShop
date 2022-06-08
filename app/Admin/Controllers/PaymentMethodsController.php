<?php

namespace App\Admin\Controllers;

use App\Models\PaymentMethod;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaymentMethodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Payment Methods';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PaymentMethod());

        $grid->column('id', __('Id'));
        $grid->column('alias', __('Alias'));
        $grid->column('name', 'Method Name');

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
        $show = new Show(PaymentMethod::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('alias', __('Alias'));
        $show->field('name', 'Method Name');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PaymentMethod());

        $form->text('alias', __('Alias'));
        $form->text('name', 'Name');

        return $form;
    }
}
