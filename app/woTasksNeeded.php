<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class woTasksNeeded extends Model
{
    protected $table = 'wo_tasks_needed';

    public function WO(){
        return $this->belongsTo('App\WO', 'wo_id'); 
     }
     public function project(){
        return $this->hasMany('App\projects', 'woTask_id'); 
     }
     public function readyToProof_projects(){
     
        return $this->project()->where('isReadyToProof', 1);
      //return null   
     }
     public function readyToFinalize_projects(){
     
      return $this->project()->where('isReadyToFinalize', 1);
    //return null   
   }
   public function proofedFile(){
      return $this->hasMany('App\proofedFile', 'woTask_id'); 
   }
   public function proofed_clientFile(){
      return $this->proofedFile()->where('type','client_file');
  } 
  public function proofed_vendorFile(){
   return $this->proofedFile()->where('type','vendor_file');
} 
   public function finalizedFile(){
      return $this->hasMany('App\finalizedFile', 'woTask_id'); 
   }
   public function finalized_projectManagerFile(){
      return $this->finalizedFile()->where('type','projectManager_file');
  }
  public function finalized_clientFile(){
   return $this->finalizedFile()->where('type','client_file');
}
   public  static function boot() {
      parent::boot();
   
      static::deleting(function($task) {
          //remove related rows region and city
          
          
          $task->finalizedFile()->delete();//
          $task->proofedFile()->delete();//
          $task->project()->delete();// 
         
          return true;
      });
   }
}
