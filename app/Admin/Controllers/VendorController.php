<?php

namespace App\Admin\Controllers;

use App\Models\Country;
use App\Models\Vendor;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VendorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vendor';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Vendor());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('alias', __('Alias'));
        $grid->column('country_id', 'Country')->display(function ($country_id) {
            return Country::where('id', $country_id)->first()->name ?? "No country";
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
        $show = new Show(Vendor::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('alias', __('Alias'));
        $show->field('country_id', 'Country')->as(function ($country_id) {
            return Country::where('id', $country_id)->first()->name ?? "No country";
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
        $form = new Form(new Vendor());

        $form->text('name', __('Name'));
        $form->text('alias', __('Alias'));
        $form->select('country_id', 'Country')->options(Country::all()->pluck('name','id'));
        return $form;
    }
}
