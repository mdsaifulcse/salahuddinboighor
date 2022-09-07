<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            [
                'id'=>'1',
                'name'=>'First Author',
                'name_bn'=>'First Author',
                'link'=>'first-author',
                'serial_num'=>1,
                'status'=>Author::ACTIVE,
                'created_by'=>1,
            ],

            [
                'id'=>'2',
                'name'=>'New Author',
                'name_bn'=>'New Author',
                'link'=>'new-author',
                'serial_num'=>2,
                'status'=>Author::ACTIVE,
                'created_by'=>1,
            ],

        ];


        if (empty(Author::first())){
            Author::insert($authors);
        }


    }
}
