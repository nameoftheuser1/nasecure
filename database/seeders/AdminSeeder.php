<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roleAdmin = Role::firstOrCreate(['id' => 2], ['name' => 'admin']);

        $adminUser = User::where('email', 'admin')->first();

        if (!$adminUser) {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'contact' => '1234567890',
                'email' => 'admin',
                'password' => Hash::make('admin'),
                'role_id' => $roleAdmin->id,
            ]);
        }
    }
}
