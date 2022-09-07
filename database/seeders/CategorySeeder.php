<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id'=>'1',
                'category_name'=>'Bongobondho',
                'category_name_bn'=>'বঙ্গবন্ধু',
                'link'=>'bongobondho',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],

            [
                'id'=>'2',
                'category_name'=>'Bangladesh',
                'category_name_bn'=>'বাংলাদেশ',
                'link'=>'bangladesh',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],

            [
                'id'=>'3',
                'category_name'=>'Liberation War',
                'category_name_bn'=>'মুক্তিযুদ্ধ',
                'link'=>'liberation-war',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>4,
                'category_name'=>'Bangabandhu is popular',
                'category_name_bn'=>'বঙ্গবন্ধুর জনপ্রিয়',
                'link'=>'bangabandhu-popular',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>5,
                'category_name'=>'Sheikh Hasina',
                'category_name_bn'=>'শেখ হাসিনা',
                'link'=>'sheikh-hasina',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>6,
                'category_name'=>'Sheikh Russell',
                'category_name_bn'=>'শেখ রাসেলের',
                'link'=>'sheikh-russell',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>7,
                'category_name'=>'The story',
                'category_name_bn'=>'গল্প',
                'link'=>'story',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>8,
                'category_name'=>'Novel',
                'category_name_bn'=>'উপন্যাস',
                'link'=>'novel',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>9,
                'category_name'=>'Poetry',
                'category_name_bn'=>'কবিতা',
                'link'=>'poetry',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>10,
                'category_name'=>'Bestseller books',
                'category_name_bn'=>'বেস্টসেলার বই',
                'link'=>'bestseller-books',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
            [
                'id'=>11,
                'category_name'=>'In Stock Books',
                'category_name_bn'=>'ইন স্টক বুকস',
                'link'=>'in-stock',
                'icon_class'=>'fa fa-home',
                'serial_num'=>'1',
                'show_home'=>Category::YES,
                'status'=>Category::ACTIVE,
                'created_by'=>1,
            ],
        ];

        $category=Category::first();

        if (empty($category)){
            Category::insert($categories);
        }
    }
}
