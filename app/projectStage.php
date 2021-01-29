<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\WO;
use App\woSourceFile;
class projectStage extends Model
{
    protected $table = 'project_stages';
    //public $timestamps = false;


    public function vendorDelivery(){
        return $this->hasMany('App\vendorDelivery','stage_id');
    }
    public function deliveryFiles(){
        return $this->hasMany('App\deliveryFiles','stage_id');
    }
    public function WO(){
        return $this->belongsTo('App\WO');
    }
    public function project(){
        return $this->belongsTo('App\projects');
    }
    public function project_sourceFile(){
        return $this->WO;
    }
   

}
