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

     public function projects(){
        return $this->belongsTo('App\projects'); 
     } 

     public function editedFile(){
        return $this->hasOne('App\editedFile','sourceFile_id');
    }
    public function finalizedFile(){
        return $this->hasOne('App\finalizedFile','sourceFile_id');
    } 
}
