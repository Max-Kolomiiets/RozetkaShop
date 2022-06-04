<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_data = File::get("database\seeders\countries.json");
        $countries = json_decode($json_data);
        foreach ($countries as $country) {
            Country::factory()->create((array)$country);
        }
    }
}
