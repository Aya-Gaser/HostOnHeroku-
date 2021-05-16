<?php

use Illuminate\Database\Seeder;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'slug' => 'admin'
            
        ]);
        DB::table('roles')->insert([
            'name' => 'vendor',
            'slug' => 'vendor'
            
        ]);
        DB::table('roles')->insert([
            'name' => 'superAdmin',
            'slug' => 'superAdmin'
            
        ]);
        DB::table('roles')->insert([
            'name' => 'projectsManager',
            'slug' => 'projectsManager'
            
        ]);
        DB::table('roles')->insert([
            'name' => 'administrativeManager',
            'slug' => 'administrativeManager'
            
        ]);
        DB::table('roles')->insert([
            'name' => 'administrativeManager_assistant',
            'slug' => 'administrativeManager_assistant'
            
        ]);
    }
}
