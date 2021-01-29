<?php

namespace App\Http\Controllers\projects;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\WoRecieved;
use App\projects;
use App\WO;
use App\User;
use alert;
use App\client;
use App\languages;
use Illuminate\Http\RedirectResponse;
use Auth;

class viewWoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
 
    
    public function getWo_Id(){
      
       $route = Route::current();        
       $wo_id = $route->id;
       return $wo_id;

    }

    public function index(){
        $route_id = $this->getWo_Id();
        $wo = WO::findOrFail($route_id);
        $projects = $wo->projects;
        $clients = $this->getClients();
        $languages = $this->getLanguages();
      //  date_default_timezone_set("America/Guayaquil");
        
        return view('admins.viewWo')->with(['wo'=>$wo, 'projects'=>$projects, 'clients'=>$clients,
        'languages'=>$languages]);
    }
    
    public function getClients(){
   
        $clients = client::all();
        return $clients;
   
    }
    public function getLanguages(){
   
        $languages = languages::all();
       // return View::make("admins.CreateWo")->with($languages);
        return $languages;
   
    }
    public function getWoProjects($wo){
        $projects = $wo->projects->get()->orderBy('created_at');
        
        return $projects;

    }

    public function recieveWo($wo_id){
        $wo = WO::find($wo_id);
        $wo->isReceived = true;
        $wo->save();
        $woCreator = User::find($wo->created_by_id);
        Mail::to($woCreator->email)->send(new WoRecieved($wo->id));
        return back();
    }

    public function updateWo($woId){

        $wo = WO::findOrFail($woId);
        $request = new Request();
        if(request()['client_number'])
           $wo->client_id = request()['client_number'];
        if(request()['client_rate'])
           $wo->client_rate = request()['client_rate'];
        if(request()['from_language'])
           $wo->from_language = request()['from_language'];
        if(request()['to_language'])
           $wo->to_language = request()['to_language'];
        if(request()['deadline'])
           $wo->deadline = LocalTime_To_UTC(request()['deadline'], Auth::user()->timezone); 
        if(request()['words_count'])
           $wo->words_count = request()['words_count'];
        if(request()['quality_points'])
           $wo->quality_points = request()['quality_points'];
        if(request()['client_instructions'])
           $wo->client_instructions = request()['client_instructions'];
        if(request()['general_instructions'])
           $wo->general_instructions = request()['general_instructions'];   
        

       $wo->save(); 
       return back();   
    }
    
 
    
}
