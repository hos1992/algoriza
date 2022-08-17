<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //        \App\Models\Admin::factory(10000)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // seed the super admin
        $superAdmin = Admin::updateOrCreate(['email' => 'admin@admin.com'], [
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'super' => true,
        ]);

        $role = Role::updateOrCreate(['name' => 'super-admin'], ['name' => 'super-admin', 'guard_name' => 'admin']);

        $superAdmin->assignRole($role);


        $this->call(PermissionsSeeder::class);
    }
}
