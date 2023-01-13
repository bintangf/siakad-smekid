<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'trash']);
        Permission::create(['name' => 'master']);
        Permission::create(['name' => 'rapor']);
        Permission::create(['name' => 'lihat nilai']);
        Permission::create(['name' => 'input nilai']);
        Permission::create(['name' => 'keuangan']);
        // create roles and assign created permissions

        $role = Role::create(['name' => 'guru']);
        $role->givePermissionTo(['input nilai', 'lihat nilai']);

        $role = Role::create(['name' => 'wali kelas'])
            ->givePermissionTo(['input nilai', 'lihat nilai', 'rapor']);

        $role = Role::create(['name' => 'bendahara'])
            ->givePermissionTo(['keuangan']);

        $role = Role::create(['name' => 'operator'])
            ->givePermissionTo(['lihat nilai', 'rapor', 'master']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['input nilai', 'lihat nilai', 'rapor', 'master', 'trash', 'keuangan']);
    }
}
