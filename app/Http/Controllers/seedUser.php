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
        $vendor->userName = 'ayaaaaa';
         $vendor->account_type = 'admin';
         $vendor->password = bcrypt('123456789');
         $vendor->visible = encrypt('123456789');
         $vendor->save();
         $users = User::all();
         return $users;
    }
}
