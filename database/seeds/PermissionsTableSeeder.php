<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //Permission list
         Permission::create(['name' => 'users_index']);
         Permission::create(['name' => 'users_edit']);
         Permission::create(['name' => 'users_create']);
         Permission::create(['name' => 'users_destroy']);
         Permission::create(['name' => 'client_index']);
         Permission::create(['name' => 'client_edit']);
         Permission::create(['name' => 'client_create']);
         Permission::create(['name' => 'client_destroy']);


         $role = Role::create(['name' => 'vendedor'])
         ->givePermissionTo(['client_index', 'client_edit','client_create','client_destroy']);

        $roles= Role::create(['name' => 'Admin']);
        $roles->givePermissionTo(Permission::all());



    }
}
