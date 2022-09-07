<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Setting;
use App\Models\SubMenu;
use App\Models\SubSubMenu;
use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (empty(Setting::first())) {


            Setting::insert(['id' => 1, 'company_name' => 'Demo Company', 'company_title' => 'Company Title Here']);


            $menus = [
                [
                    'id' => '1',
                    'name' => 'Acl',
                    'url' => 'javascript:;',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '1',
                    'slug' => '["acl"]',
                ],

                [
                    'id' => '2',
                    'name' => 'Setting',
                    'url' => 'javascript:;',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '2',
                    'slug' => '["setting"]',
                ],
                [
                    'id' => '3',
                    'name' => 'Account Setting',
                    'url' => 'javascript:;',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '3',
                    'slug' => '["account-setting"]',
                ],
                [
                    'id' => '4',
                    'name' => 'Products',
                    'url' => 'javascript:;',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '3',
                    'slug' => '["products"]',
                ],
            ];


            Menu::insert($menus);

            // -------------------------
            $subMenus = [

                [
                    'id' => '1',
                    'menu_id' => '1',
                    'name' => 'Role',
                    'url' => 'admin/roles',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '1',
                    'slug' => '["role-delete","role-edit","role-create","role-list"]',
                ],

                [
                    'id' => '2',
                    'menu_id' => '2',
                    'name' => 'Menu',
                    'url' => 'admin/menu',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '2',
                    'slug' => '["menu"]',
                ],

                [
                    'id' => '3',
                    'menu_id' => '2',
                    'name' => 'Brands',
                    'url' => 'admin/brands',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '3',
                    'slug' => '["brand"]',
                ],
                [
                    'id' => '4',
                    'menu_id' => '2',
                    'name' => 'Categories',
                    'url' => 'admin/categories',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '4',
                    'slug' => '["categories"]',
                ],
                [
                    'id' => '5',
                    'menu_id' => '2',
                    'name' => 'Divisions',
                    'url' => 'admin/divisions',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '5',
                    'slug' => '["divisions"]',
                ],
                [
                    'id' => '6',
                    'menu_id' => '2',
                    'name' => 'Slider',
                    'url' => 'admin/slider',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '6',
                    'slug' => '["slider"]',
                ],
                [
                    'id' => '7',
                    'menu_id' => '2',
                    'name' => 'Social-icon',
                    'url' => 'admin/social-icon',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '7',
                    'slug' => '["social-icon"]',
                ],
                [
                    'id' => '8',
                    'menu_id' => '2',
                    'name' => 'Testimonial',
                    'url' => 'admin/testimonial',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '8',
                    'slug' => '["testimonial"]',
                ],
                [
                    'id' => '9',
                    'menu_id' => '2',
                    'name' => 'Faq',
                    'url' => 'admin/faq',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '9',
                    'slug' => '["faq"]',
                ],
                [
                    'id' => '10',
                    'menu_id' => '2',
                    'name' => 'Client',
                    'url' => 'admin/client',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '10',
                    'slug' => '["client"]',
                ],
                [
                    'id' => '11',
                    'menu_id' => '2',
                    'name' => 'Pages',
                    'url' => 'admin/pages',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '11',
                    'slug' => '["pages"]',
                ],
                [
                    'id' => '12',
                    'menu_id' => '2',
                    'name' => 'Site Setting',
                    'url' => 'admin/setting',
                    'icon_class' => 'fa fa-home',
                    'serial_num' => '12',
                    'slug' => '["setting"]',
                ],
                [
                    'id' => '13',
                    'menu_id' => '2',
                    'name' => 'Users',
                    'url' => 'admin/users',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '13',
                    'slug' => '["setting"]',
                ],
                [
                    'id' => '14',
                    'menu_id' => '2',
                    'name' => 'Author',
                    'url' => 'admin/authors',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '14',
                    'slug' => '["authors"]',
                ],
                [
                    'id' => '15',
                    'menu_id' => '2',
                    'name' => 'Publisher',
                    'url' => 'admin/publishers',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '15',
                    'slug' => '["publishers"]',
                ],
                [
                    'id' => '16',
                    'menu_id' => '2',
                    'name' => 'Country',
                    'url' => 'admin/countries',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '16',
                    'slug' => '["countries"]',
                ],
                [
                    'id' => '17',
                    'menu_id' => '2',
                    'name' => 'Biggapons',
                    'url' => 'admin/biggapons',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '17',
                    'slug' => '["biggapons"]',
                ],
                [
                    'id' => '18',
                    'menu_id' => '2',
                    'name' => 'shipping-method',
                    'url' => 'admin/shipping-method',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '18',
                    'slug' => '["shipping-method"]',
                ],
                [
                    'id' => '19',
                    'menu_id' => '2',
                    'name' => 'Language',
                    'url' => 'admin/languages',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '19',
                    'slug' => '["languages"]',
                ],
                [
                    'id' => '20',
                    'menu_id' => '3',
                    'name' => 'Vendors',
                    'url' => 'admin/vendors',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '20',
                    'slug' => '["menu"]',
                ],
                [
                    'id' => '21',
                    'menu_id' => '3',
                    'name' => 'Expenditures',
                    'url' => 'admin/expenditures',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '21',
                    'slug' => '["menu"]',
                ],
                [
                    'id' => '22',
                    'menu_id' => '3',
                    'name' => 'Bank Accounts',
                    'url' => 'admin/bank-accounts',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '22',
                    'slug' => '["menu"]',
                ],
                [
                    'id' => '23',
                    'menu_id' => '3',
                    'name' => 'Income Expense Heads',
                    'url' => 'admin/income-expense-heads',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '23',
                    'slug' => '["menu"]',
                ],
                [
                    'id' => '24',
                    'menu_id' => '3',
                    'name' => 'Income Expense Sub Heads',
                    'url' => 'admin/income-expense-heads',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '24',
                    'slug' => '["menu"]',
                ],
                [
                    'id' => '25',
                    'menu_id' => '4',
                    'name' => 'Product List',
                    'url' => 'admin/products',
                    'icon_class' => 'fa fa-user',
                    'serial_num' => '24',
                    'slug' => '["products"]',
                ],
            ];

            SubMenu::insert($subMenus);
        }

    }
}
