<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);

        $create_post = Permission::create(['name' => 'create posts']);
        $edit_post = Permission::create(['name' => 'edit posts']);
        $delete_post = Permission::create(['name' => 'delete posts']);

        $admin->syncPermissions([$create_post, $edit_post, $delete_post]);
    }
}
