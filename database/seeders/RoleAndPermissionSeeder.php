<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'm_supp']);
        Permission::create(['name' => 'm_cust']);
        Permission::create(['name' => 'm_unit']);

        Permission::create(['name' => 'm_brand']);
        Permission::create(['name' => 'm_categ']);
        Permission::create(['name' => 'm_prod']);
        Permission::create(['name' => 'm_purch']);
        Permission::create(['name' => 'm_recei']);
        Permission::create(['name' => 'm_inv']);
        Permission::create(['name' => 'm_stock']);
    }
}
