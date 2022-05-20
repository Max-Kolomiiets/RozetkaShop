<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('parent_id', 'Parent Name')->display(function ($parent_id) {
            return Category::where('id', $parent_id)->first()->name ?? "No parent";
        })->sortable();
        
        $grid->column('name', __('Name'))->sortable();
        $grid->column('alias', __('Alias'));

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
        $show = new Show(Category::findOrFail($id));


        Category::all();

        $show->field('id', __('Id'));
        $show->field('parent_id', 'Parent Category')->as(function ($parent_id) {
            return Category::where('id', $parent_id)->first()->name ?? "No parent";
        });
        $show->field('name', __('Name'));
        $show->field('alias', __('Alias'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->tab('Common', function($form) {
            $form->select('parent_id', 'Parent category')->options(Category::all()->pluck('name','id'));

            $form->text('name', __('Name'))->rules('required|min:3', [
                'min'   => 'Name can not be less than 3 characters',
            ]);
            $form->text('alias', __('Alias'))->rules('required|min:3', [
                'min'   => 'Alias can not be less than 3 characters',
            ]);
        });

        $form->tab('Attributes', function($form) {
            $form->hasMany('category_attributes', 'Attributes', function (Form\NestedForm $form) {
                $form->hidden('attribute_id')->value(1);
                $form->text('attribute.name');
                $form->text('attribute.alias');
                $form->text('attribute.value_type');
                $form->switch('attribute.filter', 'Show in filter');
                $form->switch('attribute.required', 'Is Required');
            });
        });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        
        return $form;
    }
}
