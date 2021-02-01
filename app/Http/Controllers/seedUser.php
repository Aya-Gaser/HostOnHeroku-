<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\userRole;
class seedUser extends Controller
{
    public function index(){
       /*
        $user = new User();
        $user->name = 'Rabea';
        $user->email = 'Rabea.tarjamat@gmail.com';
        $user->userName = 'Rabea';
         $user->account_type = 'admin';
         $user->password = bcrypt('123456789');
         $user->visible = encrypt('123456789');
         $user->birthdate = ('2021-01-03');
         $user->save();

         $user = new User();
        $user->name = 'Reeno';
        $user->email = 'Reeno.tarjamat@gmail.com';
        $user->userName = 'Reeno';
         $user->account_type = 'admin';
         $user->password = bcrypt('123456789');
         $user->visible = encrypt('123456789');
         $user->birthdate = ('2021-01-03');
         $user->save();

         $user = new User();
        $user->name = 'Projects.tarjamat';
        $user->email = 'Projects.tarjamatllc@gmail.com';
        $user->userName = 'Projects';
         $user->account_type = 'admin';
         $user->password = bcrypt('123456789');
         $user->visible = encrypt('123456789');
         $user->birthdate = ('2021-01-03');
         $user->save();
         $users = User::all();
         */
       /* $role = new Role();
        $role->name = 'admin';
        $role->slug = 'admin';
        $role->save();
        $role = new Role();
        $role->name = 'vendor';
        $role->slug = 'vendor';
        $role->save(); */

        $roleuser = new userRole();
        $roleuser->user_id= 21;
        $roleuser->role_id = 1;
        $roleuser->save();
        $roleuser = new userRole();
        $roleuser->user_id= 31;
        $roleuser->role_id = 1;
        $roleuser->save();
        $roleuser = new userRole();
        $roleuser->user_id= 41;
        $roleuser->role_id = 1;
        $roleuser->save();
       
         
         
         $roles = Role::all();
         return $roles;
    }
}
