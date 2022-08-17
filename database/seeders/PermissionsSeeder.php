<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // admins model permissions
            ['module' => 'admins', 'name' => 'index-admin', 'guard_name' => 'admin'],
            ['module' => 'admins', 'name' => 'show-admin', 'guard_name' => 'admin'],
            ['module' => 'admins', 'name' => 'create-admin', 'guard_name' => 'admin'],
            ['module' => 'admins', 'name' => 'edit-admin', 'guard_name' => 'admin'],
            ['module' => 'admins', 'name' => 'delete-admin', 'guard_name' => 'admin'],

            // users model permissions
//            ['module' => 'users', 'name' => 'index-user', 'guard_name' => 'admin'],
//            ['module' => 'users', 'name' => 'show-user', 'guard_name' => 'admin'],
//            ['module' => 'users', 'name' => 'create-user', 'guard_name' => 'admin'],
//            ['module' => 'users', 'name' => 'edit-user', 'guard_name' => 'admin'],
//            ['module' => 'users', 'name' => 'delete-user', 'guard_name' => 'admin'],

            // roles model permissions
            ['module' => 'roles', 'name' => 'index-role', 'guard_name' => 'admin'],
            ['module' => 'roles', 'name' => 'show-role', 'guard_name' => 'admin'],
            ['module' => 'roles', 'name' => 'create-role', 'guard_name' => 'admin'],
            ['module' => 'roles', 'name' => 'edit-role', 'guard_name' => 'admin'],
            ['module' => 'roles', 'name' => 'delete-role', 'guard_name' => 'admin'],

            // roles model permissions
            ['module' => 'categories', 'name' => 'index-category', 'guard_name' => 'admin'],
            ['module' => 'categories', 'name' => 'show-category', 'guard_name' => 'admin'],
            ['module' => 'categories', 'name' => 'create-category', 'guard_name' => 'admin'],
            ['module' => 'categories', 'name' => 'edit-category', 'guard_name' => 'admin'],
            ['module' => 'categories', 'name' => 'delete-category', 'guard_name' => 'admin'],

            // roles model permissions
            ['module' => 'products', 'name' => 'index-product', 'guard_name' => 'admin'],
            ['module' => 'products', 'name' => 'show-product', 'guard_name' => 'admin'],
            ['module' => 'products', 'name' => 'create-product', 'guard_name' => 'admin'],
            ['module' => 'products', 'name' => 'edit-product', 'guard_name' => 'admin'],
            ['module' => 'products', 'name' => 'delete-product', 'guard_name' => 'admin'],

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate($permission, $permission);
        }
    }
}
