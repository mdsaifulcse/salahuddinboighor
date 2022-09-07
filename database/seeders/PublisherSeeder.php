<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publishers = [
            [
                'id'=>'1',
                'name'=>'First Publisher',
                'name_bn'=>'First Publisher',
                'serial_num'=>1,
                'status'=>Publisher::ACTIVE,
                'created_by'=>1,
            ],

            [
                'id'=>'2',
                'name'=>'New Publisher',
                'name_bn'=>'New Publisher',
                'serial_num'=>2,
                'status'=>Publisher::ACTIVE,
                'created_by'=>1,
            ],
        ];


        if (empty(Publisher::first())){
            Publisher::insert($publishers);
        }

    }
}
