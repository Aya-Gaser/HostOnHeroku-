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
            'name' => 'Aya2',
            'email' => 'ayagaser39@gmail.com',
            'password' =>bcrypt('password'),
            'userName' =>'aya',
            'isFirstLogin'=>1,
            'account_type'=>'admin'
        ]);

        
    }
}
