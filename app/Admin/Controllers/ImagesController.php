<?php

namespace App\Admin\Controllers;

use App\Models\Image;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ImagesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Image';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Image());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('alias', __('Alias'));
        $grid->column('url', 'Image')->image();
        $grid->column('alt', 'Alt Text');
        $grid->column('title', __('Title'))->sortable();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('product_id', 'Product')->display(function ($product_id) {
            return Product::where('id', $product_id)->first()->name ?? "N/A";
        })->sortable();

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
        $show = new Show(Image::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('alias', __('Alias'));
        $show->url()->image();
        //$show->field('url', '')->label();
        $show->field('alt', 'Alt Text');
        $show->field('title', __('Title'));
        $show->field('product_id', 'Product Name')->as(function ($product_id) {
            return Product::where('id', $product_id)->first()->name ?? "N/A";
        });

        $show->field('created_at', __('Created at'));
        $show->field('id', __('Id'));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Image());

        $form->text('alias', __('Alias'));
        $form->image('url', 'Image Path');
        $form->text('alt', __('Alt'));
        $form->text('title', __('Title'));
        $form->select('product_id', __('Product id'))->options(Product::all()->pluck('name','id'));
        return $form;
    }
}
