<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $countries_cnt = 10;
    public $vendors_cnt = 20;

    public function run()
    {
        $countries = Country::factory()->count($this->countries_cnt)->create()->all();
        for ($i=0; $i < $this->vendors_cnt; $i++) {
            Vendor::factory()->create(['country_id'=>$countries[rand(0, count($countries) - 1)]]);
        }
    }
}
