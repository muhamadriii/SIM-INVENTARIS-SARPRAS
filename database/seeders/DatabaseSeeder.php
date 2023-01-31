<?php

namespace Database\Seeders;
use Database\Seeders\UserSeeder;
use Database\Seeders\PermissionSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                UserSeeder::class,
                // RoleSeeder::class,
                MenuSeeder::class,
                PermissionSeeder::class,
            ]
        );
    }
}
