<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Role::truncate();
        Permission::truncate();

        Schema::enableForeignKeyConstraints();

        Role::create(['name' => 'superadmin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'admin'])->givePermissionTo([]);
        Role::create(['name' => 'customer'])->givePermissionTo([]);
    }
}
