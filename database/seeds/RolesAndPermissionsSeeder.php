<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'guru']);
        $role->givePermissionTo(['input nilai', 'lihat nilai']);

        // or may be done by chaining
        $role = Role::create(['name' => 'wali kelas'])
            ->givePermissionTo(['lihat nilai', 'rapor']);

        $role = Role::create(['name' => 'operator'])
            ->givePermissionTo(['lihat nilai', 'rapor', 'master']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['lihat nilai', 'rapor', 'master', 'trash']);
    }
}
