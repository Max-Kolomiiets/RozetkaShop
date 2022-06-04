<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Dashboard')
            ->description('Welcome to Ukrmarket admin part')
            ->row("<div class='title'>Ukrmarket.com - Admin panel</div>")

            ->row(function (Row $row) {

                $row->column(6, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });
            });
    }
}
