<?php

namespace App\Http\Controllers\projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\client;
class clientController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth');
     } 
   // hash password ->>>>>>> 'password' => Hash::make($request->newPassword)
     public function createClient(){
         $client = new client();
         $client->name = request()['name'];
         $client->code = request()['code'];
         
         $client->save();

         return back();


     }
     public function allclients(){
        $clients = client::orderBy('created_at','desc')->get();
        return view('admins.viewAllClients')->with(['clients'=> $clients]);
    
    }
   
    public function viewclient($client_id){
        $client = client::findOrFail($client_id);
        return view('admins.viewClient')->with(['client'=> $client]);

    }

    public function updateclient($client_id){ 
        $client = client::findOrFail($client_id);
        $client->name = request()['name'];
       
        $client->save();

        return back();
    }

    public function destroy($client_id){
        $client = client::findOrFail($client_id);
        $client->delete();
        return back();
    }
    
}
