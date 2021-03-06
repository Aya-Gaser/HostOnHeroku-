<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\JobTrait ;
use Carbon\Carbon;
use App\projectsInvitations;
use App\projects;
use App\projectStage;
use App\User;

class sendOfferToG2 extends Command
{
    use JobTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:check-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if group 1 acceptance deadline passed and no one accepted, send to group 2';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
   
    public function handle()
    {
        $stages = projectStage::where('vendor_id', 0)
        ->where('G1_acceptance_deadline','<' ,Carbon::now())
        ->where('G2_acceptance_deadline','>' ,Carbon::now())->get();
        foreach ($stages as $stage) {
            $this->publishJobToSecondGroup($stage);
            $this->info('stage of id '.$stage['id'].' published to group 2');
        }
      //  echo Carbon::now(), $stages;
    }
    
}
