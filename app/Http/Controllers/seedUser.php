<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\userRole;
use App\Permission;

class seedUser extends Controller
{
    public function index(){
      
      
        
       
         
         
         $roles = Role::all();
         $users = User::all();
         $permissions = Permission::all();
         return [$roles, $users, $permissions];
    }
}
