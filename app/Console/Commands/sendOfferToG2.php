<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\JobTrait;
use Carbon\Carbon;
use App\projectsInvitations;
use App\projects;
use App\projectStage;
class sendOfferToG2 extends Command
{
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
        $now = date('Y-m-d H:i');
        $stages = projectStage::where('vendor_id', 0)->whereDate('G1_acceptance_deadline', Carbon::parse($now))
            ->get();
        foreach ($stages as $stage) {
            $this->publishJobToSecondGroup($stage);
            $this->info('stage of id '.$stage['id'].' published to group 2');
        }
    }
}
