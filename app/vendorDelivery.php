<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class vendorDelivery extends Model
{
    protected $table = 'delivery_files';

    public function improvedFiles(){
        return $this->hasMany('App\improvedFiles','deliveryFile_id');
    }
    public function projectStage(){
        return $this->belongsTo('App\projectStage'); 
     }
     public function project_sourceFile(){
        return $this->belongsTo('App\project_sourceFile'); 
     }
     public function User(){
        return $this->belongsTo('App\User'); 
     }/*
     public function test(){
        return $this->where('stage_id',$this->projectStage); 
     }*/

     public  static function boot() {
      parent::boot();
   
      static::deleting(function($vendorDelivery) {
          //remove related rows region and city
         /* $project->project_sourceFile->each(function($sourceFile) {
              $sourceFile->vendorDelivery()->delete();
          }); */
          $sourceFile->improvedFiles()->delete();//
          
          return true;
      });
   }
}
