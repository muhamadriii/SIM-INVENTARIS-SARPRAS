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
            ['name'=>'merchant.list','guard_name'=>'web'],
            ['name'=>'merchant.create','guard_name'=>'web'],
            ['name'=>'merchant.update','guard_name'=>'web'],
            ['name'=>'merchant.delete','guard_name'=>'web'],

            ['name'=>'member.list','guard_name'=>'web'],
            ['name'=>'member.create','guard_name'=>'web'],
            ['name'=>'member.update','guard_name'=>'web'],
            ['name'=>'member.delete','guard_name'=>'web'],

            ['name'=>'product.list','guard_name'=>'web'],
            ['name'=>'product.create','guard_name'=>'web'],
            ['name'=>'product.update','guard_name'=>'web'],
            ['name'=>'product.delete','guard_name'=>'web'],

            ['name'=>'categories.list','guard_name'=>'web'],
            ['name'=>'categories.create','guard_name'=>'web'],
            ['name'=>'categories.update','guard_name'=>'web'],
            ['name'=>'categories.delete','guard_name'=>'web'],

            ['name'=>'order.list','guard_name'=>'web'],
            ['name'=>'order.create','guard_name'=>'web'],
            ['name'=>'order.update','guard_name'=>'web'],
            ['name'=>'order.delete','guard_name'=>'web'],
            ['name'=>'order.updateStatus','guard_name'=>'web'],

            ['name'=>'gallery.list','guard_name'=>'web'],
            ['name'=>'gallery.create','guard_name'=>'web'],
            ['name'=>'gallery.update','guard_name'=>'web'],
            ['name'=>'gallery.delete','guard_name'=>'web'],

            ['name'=>'unit.list','guard_name'=>'web'],
            ['name'=>'unit.create','guard_name'=>'web'],
            ['name'=>'unit.update','guard_name'=>'web'],
            ['name'=>'unit.delete','guard_name'=>'web'],

            ['name'=>'level.list','guard_name'=>'web'],
            ['name'=>'level.create','guard_name'=>'web'],
            ['name'=>'level.update','guard_name'=>'web'],
            ['name'=>'level.delete','guard_name'=>'web'],

            ['name'=>'contact-us.list','guard_name'=>'web'],
            ['name'=>'contact-us.create','guard_name'=>'web'],
            ['name'=>'contact-us.update','guard_name'=>'web'],
            ['name'=>'contact-us.delete','guard_name'=>'web'],

            ['name'=>'menu.list','guard_name'=>'web'],
            ['name'=>'menu.create','guard_name'=>'web'],
            ['name'=>'menu.update','guard_name'=>'web'],
            ['name'=>'menu.delete','guard_name'=>'web'],

            ['name'=>'level.list','guard_name'=>'web'],
            ['name'=>'level.create','guard_name'=>'web'],
            ['name'=>'level.update','guard_name'=>'web'],
            ['name'=>'level.delete','guard_name'=>'web'],

            ['name'=>'fee.list','guard_name'=>'web'],
            ['name'=>'fee.create','guard_name'=>'web'],
            ['name'=>'fee.update','guard_name'=>'web'],
            ['name'=>'fee.delete','guard_name'=>'web'],

            ['name'=>'invoice.list','guard_name'=>'web'],
            ['name'=>'invoice.create','guard_name'=>'web'],
            ['name'=>'invoice.update','guard_name'=>'web'],
            ['name'=>'invoice.delete','guard_name'=>'web'],

            ['name'=>'waiting-for-approval.list','guard_name'=>'web'],

            ['name'=>'shipping.list','guard_name'=>'web'],

            ['name'=>'unpaid.list','guard_name'=>'web'],

            ['name'=>'paid.list','guard_name'=>'web'],

            ['name'=>'finish.list','guard_name'=>'web'],
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
