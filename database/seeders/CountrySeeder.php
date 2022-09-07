<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'id'=>'1',
                'name'=>'Bangladesh',
                'name_bn'=>'Bangladesh',
                'serial_num'=>1,
                'status'=>Country::ACTIVE,
                'created_by'=>1,
            ],

            [
                'id'=>'2',
                'name'=>'New Country',
                'name_bn'=>'New Country',
                'serial_num'=>2,
                'status'=>Country::ACTIVE,
                'created_by'=>1,
            ],
        ];

        if (empty(Country::first())){
            Country::insert($countries);
        };
    }
}
