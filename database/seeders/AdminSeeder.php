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
                'contact' => '000',
                'email' => 'admin',
                'verified_at' => now(),
                'password' => Hash::make('admin'), // change what inside the parenthesis to change the default password
                'role_id' => $roleAdmin->id,
            ]);
        }
    }
}
