<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\AdminTablesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([AppSeeder::class]);
        $this->call(AdminTablesSeeder::class);
    }
}
