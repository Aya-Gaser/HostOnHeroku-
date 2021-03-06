<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project_sourceFile extends Model
{
    protected $table = 'project_source_file';

    public function vendorDelivery(){
        return $this->hasMany('App\vendorDelivery','sourceFile_id');
    } 
    public function WO(){
        return $this->belongsTo('App\WO'); 
     }

     public function project(){
        return $this->belongsTo('App\projects'); 
     } 

     public function editedFile(){
        return $this->hasOne('App\editedFile','sourceFile_id');
    }/*
    public function finalizedFile(){
        return $this->hasOne('App\finalizedFile','sourceFile_id');
    }*/
    public function proofedFile(){
        return $this->hasMany('App\proofedFile','sourceFile_id');
     } 
    
    public function proofed_vendorFile(){
        return $this->proofedFile()->where('type','vendor_file');
    }
    public function proofed_clientFile(){
        return $this->proofedFile()->where('type','client_file');
    }
    public function proofed_projectsManagerFile(){
        return $this->proofedFile()->where('type','projectsManager_file');
    } 
    

    
    public  static function boot() {
        parent::boot();
     
        static::deleting(function($sourceFile) {
            //remove related rows region and city
           /* $project->project_sourceFile->each(function($sourceFile) {
                $sourceFile->vendorDelivery()->delete();
            }); */
            $sourceFile->vendorDelivery()->delete();//
            //$sourceFile->finalizedFile()->delete();//
            $sourceFile->editedFile()->delete();// 
            $sourceFile->proofedFile()->delete();// 
            return true;
        });
     }
}
