<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class seedUser extends Controller
{
    public function index(){

         DB::table('roles')->insert([
            'name' => 'admin',
            'slug' => 'admin'
            
        ]);
        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
            
        ]);
      //   return $users;
    }
}
