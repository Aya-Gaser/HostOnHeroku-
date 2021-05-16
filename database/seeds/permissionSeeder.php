<?php

use Illuminate\Database\Seeder;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'view-tracking',
            'slug' => 'view-tracking'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'view-invoiceReports',
            'slug' => 'view-invoiceReports'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'create-wo',
            'slug' => 'create-wo'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'view-wo',
            'slug' => 'view-wo'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'view-project',
            'slug' => 'view-project'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'create-project',
            'slug' => 'create-project'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'view-proofing',
            'slug' => 'view-proofing'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'view-finalization',
            'slug' => 'view-finalization'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'validate-vendorInvoice',
            'slug' => 'validate-vendorInvoice'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'pay-vendorInvoice',
            'slug' => 'pay-vendorInvoice'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'view-vendors',
            'slug' => 'view-vendors'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'create-vendor',
            'slug' => 'create-vendor'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'view-client',
            'slug' => 'view-client'
            
        ]); 
        DB::table('permissions')->insert([
            'name' => 'create-client',
            'slug' => 'create-client'
            
        ]); 
    }
}
