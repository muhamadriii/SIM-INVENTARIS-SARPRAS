<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $permissions = [
                'role.list',
                'role.create',
                'role.update',
                'role.delete',
    
                'permission.list',
                'permission.create',
                'permission.update',
                'permission.delete',
    
                'user.list',
                'user.create',
                'user.update',
                'user.delete',
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
            $roles = [
                'superadmin',
                'merchant'
            ];
            foreach ($roles as $role) {
                Role::create(['name' => $role]);
            }
            $role_superadmin = Role::whereName('superadmin')->first();
            $role_superadmin->givePermissionTo($permissions);
            $user = User::create([
                'name' => 'Super Admin',
                'username' => 'superadmin@robust.web.id',
                'email' => 'superadmin@robust.web.id',
                'phone_number' => '+6287777284665',
                'type' => 'superadmin',
                'password' => Hash::make('superadmin123'),
            ]);
            $user->assignRole('superadmin');
            User::create([
                'name' => 'Merchant',
                'username' => 'merchant@robust.web.id',
                'email' => 'merchant@robust.web.id',
                'phone_number' => '+6287777284664',
                'type' => 'merchant',
                'password' => Hash::make('merchant123'),
            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
        }
    }
}
