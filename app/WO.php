<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WO extends Model
{
    //
    protected $table = 'wo';

    public function client(){
       return $this->belongsTo('App\client'); 
    }

    public function projects(){
        return $this->hasMany('App\projects','wo_id');
    } 
   
    public function projectStage(){
        return $this->hasMany('App\projectStage','wo_id');
    } 

    public function woTasksNeeded(){
        return $this->hasMany('App\woTasksNeeded','wo_id');
    }

    public function woFiles(){
        return $this->hasMany('App\woFiles','wo_id');
    }
    public function woSourceFiles(){
        return $this->woFiles()->where('type','source_file');
    }
    public  static function boot() {
        parent::boot();

        static::deleting(function($wo) {
            //remove related rows region and city
            $wo->projects->each(function($project) {
                $project->projectStage()->delete();
            });
            $wo->projects()->delete();//
            $wo->woFiles()->delete();//woFiles
            $wo->woTasksNeeded()->delete();//woFiles
            return true;
        });
    }
    
    
}
