<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $createPermissions = [

            ['name'=>'categories.list','guard_name'=>'web'],
            ['name'=>'categories.create','guard_name'=>'web'],
            ['name'=>'categories.update','guard_name'=>'web'],
            ['name'=>'categories.delete','guard_name'=>'web'],

            ['name'=>'unit.list','guard_name'=>'web'],
            ['name'=>'unit.create','guard_name'=>'web'],
            ['name'=>'unit.update','guard_name'=>'web'],
            ['name'=>'unit.delete','guard_name'=>'web'],

            ['name'=>'menu.list','guard_name'=>'web'],
            ['name'=>'menu.create','guard_name'=>'web'],
            ['name'=>'menu.update','guard_name'=>'web'],
            ['name'=>'menu.delete','guard_name'=>'web'],

            ['name'=>'item.list','guard_name'=>'web'],
            ['name'=>'item.create','guard_name'=>'web'],
            ['name'=>'item.update','guard_name'=>'web'],
            ['name'=>'item.delete','guard_name'=>'web'],
            ['name'=>'item.generate','guard_name'=>'web'],
            
            ['name'=>'loan.list','guard_name'=>'web'],
            ['name'=>'loan.create','guard_name'=>'web'],
            ['name'=>'loan.update','guard_name'=>'web'],
            ['name'=>'loan.delete','guard_name'=>'web'],

            ['name'=>'request.list','guard_name'=>'web'],
            ['name'=>'request.create','guard_name'=>'web'],
            ['name'=>'request.update','guard_name'=>'web'],
            ['name'=>'request.delete','guard_name'=>'web'],
        ];

        foreach($createPermissions as $permission){
            $data = Permission::where('name', $permission['name'])
                ->where('guard_name', $permission['guard_name'])
                ->first();

            if (is_null($data)){
                Permission::create([
                    'id' => Str::uuid()->toString(),
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ]);
            }

        }



    }
}
