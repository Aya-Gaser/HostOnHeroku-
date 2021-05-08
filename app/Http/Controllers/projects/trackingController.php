<?php
namespace App\Http\Controllers\projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\projects;
use App\WO;
use App\woSourceFile;
use Auth;
use App\vendorDelivery;
use App\projectStage;
use App\editedFile;
use SweetAlert;
use App\finalizedFile;
use App\woTasksNeeded;

class trackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $wos = WO::with('projects', 'projects.projectStage')->orderBy('deadline','asc')->get();

        return view('admins.tracking')->with(['wos'=>$wos]);
    }


    public function archiveTask($taskId){
        $task = woTasksNeeded::findOrFail($taskId);
        $task->status = 'Archived';
        $task->save();

        return response()->json(['success'=> 'task Archived']);
    }
}
