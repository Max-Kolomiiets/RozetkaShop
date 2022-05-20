<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Image;
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

        $form->divider();

        $form->tab('Common', function($form) {
            $form->text('name', __('Name'));
            $form->text('alias', __('Alias'));
            $form->divider();
        
            $form->select('category_id', 'Category')->options(Category::where('parent_id', '!=', 'null')->pluck('name','id'));
            $form->select('vendor_id', 'Vendor')->options(Vendor::all()->pluck('name','id'));
        
            $form->divider();
            $form->number('price.price', 'Price');
        });
        
        $form->divider();
        $form->tab('Description', function($form) {
            $form->switch('availability.availability', 'Available');
            $form->switch('availability.hiden', 'Hiden');
            $form->number('availability.quantity', 'Quantity')->rules('required|min:1|max:1000');
    
            $form->divider();
            $form->textarea('description.description', 'Description')->rows(10);
            $form->divider();
            $form->select('description.state', 'State')->options(['new' => 'New' ,'used' => 'Used', 'refurb' => 'Refurb']);
            $form->text('description.ean', 'EAN')->rules('min:13|max:13|required');
    
            $form->divider();
            $form->select('description.country_id', 'Country')->options(Country::all()->pluck('name', 'id'));
        });

        $form->divider();
        $form->tab('Media', function($form) {
            //$form->multipleSelect('images.product_id', 'Images')->options(Image::all()->pluck('name','id'));
            //$form->multipleImage('images.url', 'Images');
            //$form->hidden()
            $form->multipleImage('images','Images')->pathColumn('url')->removable();
            
        });
        
        $form->divider();
        $form->tab('Characteristics', function($form) {
            $form->hasMany('characteristics', 'Attributes', function (Form\NestedForm $form) {

                $form->text('attribute.name');
                $form->text('attribute.alias');
                $form->text('attribute.value_type');
                $form->switch('attribute.filter', 'Show in filter');
                $form->switch('attribute.required', 'Is Required');
            });
        });
        // $form->tab('Guarantee', function($form) {
        //     $form->divider();
        //     $form->text('guaranty.term', 'Term')->rules('');
        //     $form->url('guaranty.url', 'Url')->rules('');
        //     $form->text('description');
        //     $form->select('guaranty.vendor_id', 'Guarantee Vendor')->options(Vendor::all()->pluck('name','id'));
        // });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        $form->confirm('Confirm creating     new product？', 'create');


        $form->submitted(function (Form $form) {
            var_dump($form);
        });
        
        // callback before save
        $form->saving(function (Form $form) {
            var_dump($form);
        });
        
        // callback after save
        $form->saved(function (Form $form) {
            var_dump($form);
        });

        return $form;
    }
}
