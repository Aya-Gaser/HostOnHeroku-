<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\userRole;
use App\Permission;
use App\rolesPermissions;
class seedUser extends Controller
{
    public function index(){
      
      $userRole = new userRole();
      $userRole->user_id = 14;
      $userRole->role_id = 54;
      $userRole->save(); 
      
      $userRole = new userRole();
      $userRole->user_id = 24;
      $userRole->role_id = 44;
      $userRole->save(); 

      $userRole = new userRole();
      $userRole->user_id = 34;
      $userRole->role_id = 34;
      $userRole->save(); 

      $userRole = new userRole();
      $userRole->user_id = 44;
      $userRole->role_id = 34;
      $userRole->save(); 

      $userRole = new userRole();
      $userRole->user_id = 54;
      $userRole->role_id = 24;
      $userRole->save(); 
///////////////////////////////////////////////////
      $userRole = new userRole();
      $userRole->user_id = 14;
      $userRole->role_id = 4;
      $userRole->save(); 
      
      $userRole = new userRole();
      $userRole->user_id = 24;
      $userRole->role_id = 4;
      $userRole->save(); 

      $userRole = new userRole();
      $userRole->user_id = 34;
      $userRole->role_id = 4;
      $userRole->save(); 

      $userRole = new userRole();
      $userRole->user_id = 44;
      $userRole->role_id = 4;
      $userRole->save(); 

      $userRole = new userRole();
      $userRole->user_id = 54;
      $userRole->role_id = 4;
      $userRole->save(); 
      
/******************************************* */
$rolead = new Role();
   $rolead->name = 'admin';
   $rolead->slug= 'admin';
    
$rolead->save();

$roleven = new Role();
   $roleven->name = 'vendor',
   $roleven->slug= 'vendor'
    
$roleven->save();

$rolesa = new Role();
   $rolesa->name = 'superAdmin',
   $rolesa->slug= 'superAdmin'
    
$rolesa->save();

$rolepm = new Role();
   $rolepm->name = 'projectsManager',
   $rolepm->slug= 'projectsManager'
    
$rolepm->save();

$roleam = new Role();
   $roleam->name = 'administrativeManager',
   $roleam->slug= 'administrativeManager'
    
$roleam->save();

$roleams = new Role();
   $roleams->name = 'administrativeManager_assistant',
   $roleams->slug= 'administrativeManager_assistant'
    
$roleams->save();
///////////////////////////////////////////
$Permission = new Permission();
   $Permission->name = 'view-tracking';
    $Permission->slug = 'view-tracking';
    $Permission->save();     
    $Permission->roles()->attach($rolesa);
    $Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);



$Permission = new Permission();
   $Permission->name = 'view-invoiceReports';
    $Permission->slug = 'view-invoiceReports';
$Permission->save();     
$Permission->roles()->attach($rolesa);
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'create-wo';
    $Permission->slug = 'create-wo';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'view-wo';
    $Permission->slug = 'view-wo';
    
$Permission->save();  
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);   
$Permission->roles()->attach($rolesa); 

$Permission = new Permission();
   $Permission->name = 'view-project';
    $Permission->slug = 'view-project';
    
$Permission->save();     
$Permission->roles()->attach($rolesa);
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'create-project';
    $Permission->slug = 'create-project';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'view-proofing';
    $Permission->slug = 'view-proofing';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleams);    

$Permission = new Permission();
   $Permission->name = 'view-finalization';
    $Permission->slug = 'view-finalization';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'validate-vendorInvoice';
    $Permission->slug = 'validate-vendorInvoice';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
$Permission->roles()->attach($roleam);
    $Permission->roles()->attach($roleams);

$Permission = new Permission();
   $Permission->name = 'pay-vendorInvoice';
    $Permission->slug = 'pay-vendorInvoice';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
    $Permission->roles()->attach($roleams);

$Permission = new Permission();
   $Permission->name = 'view-vendors';
    $Permission->slug = 'view-vendors';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'create-vendor';
    $Permission->slug = 'create-vendor';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'view-client';
    $Permission->slug = 'view-client';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
$Permission->roles()->attach($rolepm);
    $Permission->roles()->attach($roleam);

$Permission = new Permission();
   $Permission->name = 'create-client';
    $Permission->slug = 'create-client';
    
$Permission->save();     
$Permission->roles()->attach($rolesa); 
    $Permission->roles()->attach($roleam);
         
         
         $roles = Role::all();
         $users = User::all();
         $permissions = Permission::all();
         $rolesPermissions = rolesPermissions::all();
         return [$roles, $users, $permissions, $rolesPermissions];
    }
}
