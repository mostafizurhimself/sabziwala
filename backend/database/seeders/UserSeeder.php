<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@example.com'
            ],

            [
                'name'     => 'Admin',
                'password' => bcrypt(111111),
            ],


        );

        $admin->assignRole(Role::SUPER_ADMIN);
    }
}