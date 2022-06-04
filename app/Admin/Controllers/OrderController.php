<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', __('Id'));

        $grid->column('order_number')->display(function ($order_number) {
            return "<span style='color:blue'>#$order_number</span>";
        });
        $grid->column('order_date', __('Order date'));
        $grid->column('user_id', __('User id'));
        $grid->column('user.name', 'User name');
        $grid->column('orderStatus.status', 'Order Status')->label();
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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_number', __('Order number'));
        $show->field('order_date', __('Order date'));
        $show->field('order_status_id', 'Order Status')->as(function ($status_id) {
            return OrderStatus::where('id', $status_id)->first()->status ?? "N/A";
        })->label();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->user('User Info', function ($user) {
            $user->setResource('#');

            $user->id();
            $user->name();
            $user->email();

            $user->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    $tools->disableList();
                    $tools->disableDelete();
                });
        });

        $show->products('Products', function ($products) {
            $products->resource('/admin/orders-products');

            $products->column('product.id', 'Product Id');
            $products->column('product.name', 'Product name');
           
            dd( $products->column('qty', 'Quantity')
        );

            $products->column('qty', 'Quantity');

            $products->filter(function ($filter) {
                $filter->like('content');
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
        $form = new Form(new Order());

        $form->number('order_number', __('Order number'));
        $form->datetime('order_date', __('Order date'))->default(date('Y-m-d H:i:s'));
        $form->number('user_id', __('User id'));
        $form->number('order_status_id', __('Order status id'));

        return $form;
    }
}
