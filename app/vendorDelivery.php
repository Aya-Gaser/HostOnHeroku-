<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class vendorDelivery extends Model
{
    protected $table = 'delivery_files';

    public function deliveryFiles(){
        return $this->hasMany('App\deliveryFiles','delivery_id');
    }
    public function projectStage(){
        return $this->belongsTo('App\projectStage'); 
     }
     public function project_sourceFile(){
        return $this->belongsTo('App\project_sourceFile'); 
     }
     public function User(){
        return $this->belongsTo('App\User'); 
     }
     public function test(){
        return $this->where('stage_id',$this->projectStage); 
     }
}
