<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (empty($user=User::first())){

        // ---------------------- Developer
        $developer=User::create([
            'name'=>'Md.Saiful Islam',
            'email'=>'developer@developer.com',
            'username'=>'developer',
            'mobile'=>'01829655974',
            'password'=>bcrypt('12345678')
        ]);

        $developerRole=Role::create([
            'name'=>'developer'
        ]);

        $permissions = Permission::pluck('id', 'id')->all();

        $developerRole->syncPermissions($permissions);

        $developer->assignRole([$developerRole->id]);

        // ----------------------------- Admin

        $admin=User::create([
            'name'=>'Admin',
            'email'=>'admin@admin.com',
            'username'=>'admin',
            'mobile'=>'01999999991',
            'password'=>bcrypt('12345678')
        ]);

        $role=Role::create([
            'name'=>'admin'
        ]);


        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);


        //  -------------- Customer


        $user=User::create([
            'name'=>'General User',
            'email'=>'user@user.com',
            'username'=>'user',
            'mobile'=>'0199999992',
            'password'=>bcrypt('12345678')
        ]);

        $customerRole=Role::create([
            'name'=>'general-customer'
        ]);
        $user->assignRole([$customerRole->id]);
        }
    }
}
