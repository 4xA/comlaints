<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@complaints.com',
            'password' => Hash::make('Password1234')
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'customer',
            'email' => 'customer@complaints.com',
            'password' => Hash::make('Password1234')
        ]);
        $user->assignRole('customer');
    }
}
