<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        \Encore\Admin\Auth\Database\Menu::truncate();
        \Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "Dashboard",
                    "icon" => "fa-bar-chart",
                    "uri" => "/",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 21,
                    "title" => "Admin",
                    "icon" => "fa-tasks",
                    "uri" => "",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 22,
                    "title" => "Users",
                    "icon" => "fa-users",
                    "uri" => "auth/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 23,
                    "title" => "Roles",
                    "icon" => "fa-user",
                    "uri" => "auth/roles",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 24,
                    "title" => "Permission",
                    "icon" => "fa-ban",
                    "uri" => "auth/permissions",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 25,
                    "title" => "Menu",
                    "icon" => "fa-bars",
                    "uri" => "auth/menu",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 26,
                    "title" => "Operation log",
                    "icon" => "fa-history",
                    "uri" => "auth/logs",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 4,
                    "title" => "Categories",
                    "icon" => "fa-list",
                    "uri" => "categories",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 3,
                    "title" => "Products",
                    "icon" => "fa-list",
                    "uri" => "products",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 26,
                    "order" => 13,
                    "title" => "Users",
                    "icon" => "fa-list",
                    "uri" => "users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 26,
                    "order" => 14,
                    "title" => "Cart",
                    "icon" => "fa-list",
                    "uri" => "cart",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 26,
                    "order" => 15,
                    "title" => "Wish-list",
                    "icon" => "fa-list",
                    "uri" => "wish-list",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 11,
                    "title" => "Vendors",
                    "icon" => "fa-list",
                    "uri" => "vendors",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 10,
                    "title" => "Countries",
                    "icon" => "fa-list",
                    "uri" => "countries",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 8,
                    "title" => "Availabilities",
                    "icon" => "fa-list",
                    "uri" => "availabilities",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 9,
                    "title" => "Images",
                    "icon" => "fa-list",
                    "uri" => "images",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 5,
                    "title" => "Attributes",
                    "icon" => "fa-list",
                    "uri" => "attributes",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 6,
                    "title" => "Characteristics",
                    "icon" => "fa-list",
                    "uri" => "characteristics",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 24,
                    "order" => 7,
                    "title" => "Category-attributes",
                    "icon" => "fa-list",
                    "uri" => "category-attributes",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 25,
                    "order" => 17,
                    "title" => "Orders",
                    "icon" => "fa-list",
                    "uri" => "orders",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 25,
                    "order" => 18,
                    "title" => "Order-statuses",
                    "icon" => "fa-list",
                    "uri" => "order-statuses",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 25,
                    "order" => 20,
                    "title" => "Delivery-methods",
                    "icon" => "fa-list",
                    "uri" => "delivery-methods",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 25,
                    "order" => 19,
                    "title" => "Payment-methods",
                    "icon" => "fa-list",
                    "uri" => "payment-methods",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "Products Management",
                    "icon" => "fa-amazon",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 16,
                    "title" => "Orders Management",
                    "icon" => "fa-calculator",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 12,
                    "title" => "Users Management",
                    "icon" => "fa-bold",
                    "uri" => NULL,
                    "permission" => NULL
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Permission::truncate();
        \Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    "name" => "All permission",
                    "slug" => "*",
                    "http_method" => "",
                    "http_path" => "*"
                ],
                [
                    "name" => "Dashboard",
                    "slug" => "dashboard",
                    "http_method" => "GET",
                    "http_path" => "/"
                ],
                [
                    "name" => "Login",
                    "slug" => "auth.login",
                    "http_method" => "",
                    "http_path" => "/auth/login\r\n/auth/logout"
                ],
                [
                    "name" => "User setting",
                    "slug" => "auth.setting",
                    "http_method" => "GET,PUT",
                    "http_path" => "/auth/setting"
                ],
                [
                    "name" => "Auth management",
                    "slug" => "auth.management",
                    "http_method" => "",
                    "http_path" => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs"
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Role::truncate();
        \Encore\Admin\Auth\Database\Role::insert(
            [
                [
                    "name" => "Administrator",
                    "slug" => "administrator"
                ]
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2
                ]
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 1
                ]
            ]
        );

        // finish
    }
}
