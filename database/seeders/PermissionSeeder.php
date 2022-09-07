<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'inventory-stock-report',

            'vendor-payments-list',
            'vendor-payments-create',
            'vendor-payments-edit',
            'vendor-payments-delete',

            'vendor-list',
            'vendor-create',
            'vendor-edit',
            'vendor-delete',

            'product-adjustment-list',
            'product-adjustment-create',
            'product-adjustment-edit',
            'product-adjustment-delete',

            'purchase-return-list',
            'purchase-return-create',
            'purchase-return-edit',
            'purchase-return-delete',

            'product-purchases',
            'bank-accounts',
            'income-expense-heads',
            'income-expense-sub-heads',

            'biggapons',
            'news-letters',
            'shipping-method',

            'expenditure-list',
            'expenditure-create',
            'expenditure-edit',
            'expenditure-delete',

            'languages',
            'countries',
            'authors',
            'publishers',

            'acl',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'product-list',
            'product-create',
            'product-edit',
            'product-delete',

            'menu',
            'client',
            'faq',
            'testimonial',
            'social-icon',
            'slider',
            'districts',
            'divisions',
            'brand',
            'origins',
            'tags',
            'vat-taxes',
            'attributes',
            'collections',
            'categories',
            'sub-categories',
            'pages',
            'setting',
            'account-setting',
            'common-public',
            'common-private',

        ];


        if (empty(Permission::first())){


        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
        }
    }
}
