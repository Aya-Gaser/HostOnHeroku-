<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class woProjectsNeeded extends Model
{
    protected $table = 'wo_tasks_needed';

    public function WO(){
        return $this->belongsTo('App\WO'); 
     }
}
