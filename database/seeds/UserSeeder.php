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
            'email' => 'ayagaser39@gmail.com',
            'userName' =>'aya',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
             'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]); //reeno admin mgr, 4 bus mgr, hoda fin asst, super : gen mgr
        DB::table('users')->insert([
            'name' => 'FIN ASST',
            'email' => 'hoda.tarjamat@gmail.com',
            'userName' =>'FIN ASST',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'ADMIN MGR',
            'email' => 'Reeno.tarjamat@gmail.com',
            'userName' =>'ADMIN MGR',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
            'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'Projects_tarjamatllc',
            'email' => 'Projects.tarjamatllc@gmail.com',
            'userName' =>'Projects_tarjamatllc',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'BUS MGR',
            'email' => 'Rabea.tarjamat@gmail.com',
            'userName' =>'BUS MGR',
            'isFirstLogin'=>1,
            'account_type'=>'admin',
            'password' => bcrypt('123456789'),
           'visible' => encrypt('123456789'),
            'birthdate' => ('2021-01-03'),
        ]);
        DB::table('users')->insert([
            'name' => 'GEN MGR',
            'email' => 'louay.abdulla@gmail.com',
            'userName' =>'GEN MGR',
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

