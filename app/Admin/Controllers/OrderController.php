<?php

namespace App\Admin\Controllers;

use App\Mail\MailService;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Request;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';
    private $sendEmail = false;
    private $mailService;

    public function __construct()
    {
        $this->mailService = new MailService();
    }
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

        $form->hidden('id');
        $form->hidden('user_id');
        $form->text('user.name')->disable();
        $form->select('order_status_id', 'Status')->options(OrderStatus::all()->pluck('status', 'id'));

        $form->saved(function (Form $form) {
            $userId = $form->user_id;
            $orderStatus = OrderStatus::find($form->order_status_id)->status;

            $this->mailService->sendEmail($userId, $orderStatus);
        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });

        return $form;
    }
}
