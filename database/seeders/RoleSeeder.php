<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin', 'guard_name' => 'api']);
        $manager = Role::create(['name' => 'Manager', 'guard_name' => 'api']);
        $user = Role::create(['name' => 'User', 'guard_name' => 'api']);

        $manager->givePermissionTo([
            'create-user',
            'edit-user',
            'view-profile',
        ]);

        $user->givePermissionTo([
            'view-user',
            'view-profile',
        ]);
    }
}