<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
class seedUser extends Controller
{
    public function index(){
       
       /* $user = new User();
        $user->name = 'Aya';
        $user->email = 'ayagaser30@gmail.com';
        $user->userName = 'ayaaaaa';
         $user->account_type = 'admin';
         $user->password = bcrypt('123456789');
         $user->visible = encrypt('123456789');
         $user->birthdate = ('2021-01-03');
         $user->save();
         $users = User::all();
         */
        /*$role = new Role();
        $role->name = 'vendor';
        $role->slug = 'vendor';
        $role->save();
        /*$roleuser = new userRole();
        $roleuser->user_id= ;
        $roleuser->role_id = 1;
        $roleuser->save();
         
         return $users;*/
         $roles = Role::all();
         return $roles
    }
}
