<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    //
    protected $table = 'projects';
    
    public function WO(){
        return $this->belongsTo('App\WO','wo_id'); 
     }
     public function User(){
        return $this->belongsTo('App\User',['translator_id','created_by_id']); 
     }
     public function editingDetails(){
        return $this->hasOne('App\editingDetails','project_id');
     }
     public function projectStage(){
      return $this->hasMany('App\projectStage','project_id');
   }
   public function project_sourceFile(){
      return $this->hasMany('App\project_sourceFile','project_id');
  }
  public function finalizedFile(){
   return $this->hasMany('App\finalizedFile','project_id');
  }
  public function projectFile(){
   return $this->hasMany('App\projectFile','project_id');
}
     
}
