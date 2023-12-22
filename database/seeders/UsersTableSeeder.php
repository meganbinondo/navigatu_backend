<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a user with role 'admin'
        DB::table('users')->insert([
            'name' => 'Admin User',
            'phone' => '1234567890',
            'organization' => 'Admin Organization',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // You can replace 'password' with the desired password
            'role' => 'admin',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Customer',
            'phone' => '9876543210',
            'organization' => 'Another Organization',
            'email' => 'customer@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add more users as needed
    }
}
