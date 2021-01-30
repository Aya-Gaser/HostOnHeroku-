<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\userRole;
class seedUser extends Controller
{
    public function index(){

        $role = new Role();
        $role->name = 'admin';
        $role->slug = 'admin';
        $role->save();
        $roleuser = new userRole();
        $roleuser->user_id= 1;
        $roleuser->role_id = 1;
        $roleuser->save();
        
      //   return $users;
    }
}
