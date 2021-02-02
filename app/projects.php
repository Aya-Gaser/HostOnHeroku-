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
public  static function boot() {
   parent::boot();

   static::deleting(function($project) {
       //remove related rows region and city
       $project->project_sourceFile->each(function($sourceFile) {
           $sourceFile->vendorDelivery()->delete();
       });
       $project->project_sourceFile()->delete();//
       $project->finalizedFile()->delete();//
       $project->projectFile()->delete();// 
       $project->projectStage()->delete();//
       return true;
   });
}
     
}
