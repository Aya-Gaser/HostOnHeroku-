<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class woProjectsNeeded extends Model
{
    protected $table = 'wo_projects_needed';

    public function WO(){
        return $this->belongsTo('App\WO'); 
     }
}
