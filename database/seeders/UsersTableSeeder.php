<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            [
                'full_name'=>'Abhi Admin',
                'username'=>'Admin',
                'email'=>'abhi@abhigeorge.com',
                'password'=>Hash::make('1111'),
                'role'=>'admin',
                'status'=>'active',
            ],

            [
                'full_name'=>'Abhi Vendor',
                'username'=>'Vendor',
                'email'=>'vendor@gmail.com',
                'password'=>Hash::make('1111'),
                'role'=>'vendor',
                'status'=>'active',
            ],

            [
                'full_name'=>'Abhi Customer',
                'username'=>'Customer',
                'email'=>'customer@gmail.com',
                'password'=>Hash::make('1111'),
                'role'=>'customer',
                'status'=>'active',
            ],
        ]);
    }
}
