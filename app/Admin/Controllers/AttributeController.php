<?php

namespace App\Admin\Controllers;

use App\Models\Attribute;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AttributeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Attribute';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Attribute());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('alias', __('Alias'));
        $grid->column('value_type', __('Value type'));
        $grid->column('filter', __('Filter'));
        $grid->column('required', __('Required'));

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
        $show = new Show(Attribute::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('alias', __('Alias'));
        $show->field('value_type', __('Value type'));
        $show->field('filter', __('Filter'));
        $show->field('required', __('Required'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Attribute());

        $form->text('name', __('Name'));
        $form->text('alias', __('Alias'));
        $form->text('value_type', __('Value type'));
        $form->switch('filter', __('Filter'));
        $form->switch('required', __('Required'));

        return $form;
    }
}
