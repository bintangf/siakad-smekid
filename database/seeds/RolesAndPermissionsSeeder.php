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
        Permission::create(['name' => 'keuangan']);
        Permission::create(['name' => 'laporan keuangan']);
        // create roles and assign created permissions

        $role = Role::create(['name' => 'guru']);
        $role->givePermissionTo(['input nilai', 'lihat nilai']);

        $role = Role::create(['name' => 'wali kelas'])
            ->givePermissionTo(['lihat nilai', 'rapor']);

        $role = Role::create(['name' => 'bendahara'])
            ->givePermissionTo(['keuangan', 'laporan keuangan']);

        $role = Role::create(['name' => 'operator'])
            ->givePermissionTo(['lihat nilai', 'rapor', 'master', 'laporan keuangan']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['lihat nilai', 'rapor', 'master', 'trash', 'laporan keuangan']);
    }
}
