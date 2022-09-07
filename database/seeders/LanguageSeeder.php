<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'id'=>'1',
                'name'=>'Bangla',
                'name_bn'=>'Bangladesh',
                'serial_num'=>1,
                'status'=>Language::ACTIVE,
                'created_by'=>1,
            ],

            [
                'id'=>'2',
                'name'=>'English',
                'name_bn'=>'English',
                'serial_num'=>2,
                'status'=>Language::ACTIVE,
                'created_by'=>1,
            ],
        ];


        if (empty(Language::first())){
            Language::insert($languages);
        };    }
}
