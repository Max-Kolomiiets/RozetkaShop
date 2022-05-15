<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('alias', __('Alias'));

        $grid->category()->name();
        $grid->vendor()->name();

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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('alias', __('Alias'));
        $show->field('category_id', __('Category id'));
        $show->field('vendor_id', __('Vendor id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->text('name', __('Name'));
        $form->text('alias', __('Alias'));
        
        $form->select('category_id', 'Category')->options(Category::where('parent_id', '!=', 'null')->pluck('name','id'));
        $form->select('vendor_id', 'Vendor')->options(Vendor::all()->pluck('name','id'));

        $form->number('price.price', 'Price');
        $form->textarea('description.description', 'Description')->rows(10);

        return $form;
    }
}
