<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $countries_cnt = 10;
    public $vendors_cnt = 20;

    private function fakeSeed()
    {
        $countries = Country::factory()->count($this->countries_cnt)->create()->all();
        for ($i=0; $i < $this->vendors_cnt; $i++) {
            Vendor::factory()->create(['country_id'=>$countries[rand(0, count($countries) - 1)]]);
        }
    }
    private function getCountry($country)
    {
        return Country::firstWhere("name", $country)->id;
    }
    public function run()
    {
        $json_data = File::get("database\\seeders\\vendors.json");
        $vendors = json_decode($json_data);
        foreach ($vendors as $vendor) {
            $vendor_data = [
                'name' => $vendor->name,
                'alias' => $vendor->alias,
                'country_id' => $this->getCountry($vendor->country)
            ];
            Vendor::factory()->create($vendor_data);
        }
    }
}
