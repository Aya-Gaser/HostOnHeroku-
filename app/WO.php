<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WO extends Model
{
    //
    protected $table = 'Wo';

    public function client(){
       return $this->belongsTo('App\client'); 
    }

    public function projects(){
        return $this->hasMany('App\projects','wo_id');
    } 
   
    public function projectStage(){
        return $this->hasMany('App\projectStage','wo_id');
    } 

    public function woProjectsNeeded(){
        return $this->hasMany('App\woProjectsNeeded','wo_id');
    }

    public function woFiles(){
        return $this->hasMany('App\woFiles','wo_id');
    }
    
    
}
