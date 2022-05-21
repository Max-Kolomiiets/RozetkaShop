<?php

namespace App\Admin\Controllers;

use App\Models\CategoryAttribute;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryAttributeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'CategoryAttribute';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CategoryAttribute());

        $grid->column('id', __('Id'));
        $grid->column('attribute_id', __('Attribute id'));
        $grid->column('category_id', __('Category id'));
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
        $show = new Show(CategoryAttribute::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('attribute_id', __('Attribute id'));
        $show->field('category_id', __('Category id'));
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
        $form = new Form(new CategoryAttribute());

        $form->tab('Attribute', function($form) {
            $form->text('attribute.name');
            $form->text('attribute.alias');
            $form->text('attribute.value_type');
            $form->switch('attribute.filter', 'Show in filter');
            $form->switch('attribute.required', 'Is Required');
        });
        
        $form->tab('Category', function($form) {
            $form->text('category.name');
            $form->text('category.alias');
        });

        return $form;
    }
}
