<?php

namespace App\Admin\Controllers;

use App\Admin\Selectable\Attributes;
use App\Models\Attribute;
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
            return Category::where('id', $parent_id)->first()->name ?? "N/A";
        })->label()->sortable();
        
        $grid->column('name', __('Name'))->sortable();
        $grid->column('alias', __('Alias'));

        $grid->attributes()->display(function ($attributes) {

            if (!$attributes) return;
            $categories = array_map(function ($attribute) {
                return "<span class='label label-success'>{$attribute['name']}</span>";
            }, $attributes);
        
            return join('&nbsp;', $categories);
        });

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
            return Category::where('id', $parent_id)->first()->name ?? "N/A";
        })->label();
        $show->field('name', __('Name'));
        $show->field('alias', __('Alias'));

        $show->attributes('Attributes', function ($attributes) {

            $attributes->resource('/admin/attributes');
        
            $attributes->id();
            $attributes->name();
            $attributes->alias();
            $attributes->value_type();
            $attributes->required();
        
            $attributes->filter(function ($filter) {
                $filter->like('name');
            });
        });

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
             $form->belongsToMany('attributes', Attributes::class, 'Attributes');
        });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        
        return $form;
    }
}
