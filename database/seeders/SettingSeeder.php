<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data=Setting::first();

        if (empty($data))
        {
            $user=Setting::create([
                'company_name'=>'Demo Company',
                'company_title'=>'Company Title',
            ]);
        }



    }
}
