<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $admin = User::create([
            'name' => "admin",
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $create = User::create([
            'name' => "create",
            'email' => 'create@create.com',
            'password' => Hash::make('password')
        ]);

        $user = User::create([
            'name' => "user",
            'email' => 'user@user.com',
            'password' => Hash::make('password')
        ]);

        $admin->roles()->attach([1,2]);
        $create->roles()->attach([2]);
        $admin->roles()->attach([3]);
    }
}
