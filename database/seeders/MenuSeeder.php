<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Menu;

use Illuminate\Support\Str;

class MenuSeeder extends Seeder
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

            $user_manage = Menu::create([
                'id' => Str::uuid()->toString(),
                'name' => 'User Management',
                'route' => NULL,
                'parent_id' => NULL,
            ]);

            $master = Menu::create([
                'id' => Str::uuid()->toString(),
                'name' => 'Data Master',
                'route' => NULL,
                'parent_id' => NULL,
            ]);

            Menu::Create([
                'id' => Str::uuid()->toString(),
                'name' => 'User',
                'route' => 'admin.users.index',
                'parent_id' => $user_manage->id,
            ]);
            Menu::Create([
                'id' => Str::uuid()->toString(),
                'name' => 'Role',
                'route' => 'admin.roles.index',
                'parent_id' => $user_manage->id,
            ]);
            Menu::Create([
                'id' => Str::uuid()->toString(),
                'name' => 'Permission',
                'route' => 'admin.permissions.index',
                'parent_id' => $user_manage->id,
            ]);
            Menu::Create([
                'id' => Str::uuid()->toString(),
                'name' => 'Menu',
                'route' => 'admin.menus.index',
                'parent_id' => $master->id,
            ]);
            Menu::Create([
                'id' => Str::uuid()->toString(),
                'name' => 'Kategory',
                'route' => 'admin.categories.index',
                'parent_id' => $master->id,
            ]);
            Menu::Create([
                'id' => Str::uuid()->toString(),
                'name' => 'Barang',
                'route' => 'admin.items.index',
                'parent_id' => $master->id,
            ]);
            Menu::Create([
                'id' => Str::uuid()->toString(),
                'name' => 'Unit',
                'route' => 'admin.unit.index',
                'parent_id' => $master->id,
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
        }
    }
}
