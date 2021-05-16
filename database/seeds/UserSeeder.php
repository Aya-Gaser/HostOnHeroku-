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
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'Hoda',
            'email' => 'hoda.tarjamat@gmail.com',
            'password' => Hash::make('password'),
            'userName' =>'Hoda',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'Reeno',
            'email' => 'Reeno.tarjamat@gmail.com',
            'password' => Hash::make('password'),
            'userName' =>'Reeno',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'Projects_tarjamatllc',
            'email' => 'Projects.tarjamatllc@gmail.com',
            'password' => Hash::make('password'),
            'userName' =>'Projects_tarjamatllc',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'Rabea',
            'email' => 'Rabea.tarjamat@gmail.com',
            'password' => Hash::make('password'),
            'userName' =>'Rabea',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'louay',
            'email' => 'louay.abdulla@gmail.com',
            'password' => Hash::make('password'),
            'userName' =>'louay',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
      
       /* 
        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
            
        ]);
        */
    }
}

