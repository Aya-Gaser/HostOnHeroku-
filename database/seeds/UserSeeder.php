<?php

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
        DB::table('users')->insert([
            'name' => 'Aya',
            'email' => 'ayagaser30@gmail.com',
            'password' => Hash::make('password'),
            'userName' =>'aya',
            'isFirstLogin'=>1,
            'account_type'=>'admin'
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'slug' => 'admin'
            
        ]);
        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
            
        ]);
    }
}
