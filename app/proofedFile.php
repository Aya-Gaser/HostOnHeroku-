<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proofedFile extends Model
{
    protected $table = 'proofed_file';

    public function project_sourceFile(){
        return $this->belongsTo('App\project_sourceFile');
    }
    public function project(){
        return $this->belongsTo('App\projects');
    }
    public function woTasksNeeded(){
        return $this->belongsTo('App\woTasksNeeded', 'woTask_id');
    }
}
