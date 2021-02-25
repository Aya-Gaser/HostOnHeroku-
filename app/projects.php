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
     public function translator(){  
      /* $translatorName =  $this->belongsTo('App\User','translator_id');
       if($translatorName)
           return $translatorName; */
       return $this->belongsTo('App\User','translator_id');    
   }
     public function creator(){
      return $this->belongsTo('App\User','created_by_id'); 
   }
     public function woTasksNeeded(){
      return $this->belongsTo('App\woTasksNeeded', 'woTask_id');
  }
     public function projectStage(){
      return $this->hasMany('App\projectStage','project_id');
   }
   public function project_sourceFile(){
      return $this->hasMany('App\project_sourceFile','project_id');
  }
  public function project_sourceFile_readyToProof(){
     return $this->project_sourceFile()->where('isReadyToProof',1);
  }
  public function project_sourceFile_readyToFilnalize(){
   return $this->project_sourceFile()->where('isReadyToFinalize',1);
}
  public function finalizedFile(){
   return $this->hasMany('App\finalizedFile','project_id');
  }
  public function projectFile(){
   return $this->hasMany('App\projectFile','project_id');
}
public function proofedFile(){
   return $this->hasMany('App\proofedFile','project_id');
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
       $project->proofedFile()->delete();//
       $project->projectFile()->delete();// 
       $project->projectStage()->delete();//
       return true;
   });
}
     
}
