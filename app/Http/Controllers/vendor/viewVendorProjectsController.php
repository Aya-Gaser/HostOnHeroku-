<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\projects;
use App\WO;
class viewVendorProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    public function index(){
        $vendor_id = Auth::user()->id;
        $undelivered_projects_translation = projects::where('translator_id', $vendor_id);
        $undelivered_projects_editing = projects::where('');
    }
}
