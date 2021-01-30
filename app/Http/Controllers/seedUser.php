<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class seedUser extends Controller
{
    public function index(){
        $user = new User();
        $user->name = 'Aya';
        $user->email = 'ayagaser30@gmail.com';
        $user->userName = 'ayaaaaa';
         $user->account_type = 'admin';
         $user->password = bcrypt('123456789');
         $user->visible = encrypt('123456789');
         $user->birthdate = ('2021-01-03');
         $user->save();
         $users = User::all();
         return $users;
    }
}
