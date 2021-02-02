<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class woFiles extends Model
{
    protected $table = 'wo_files';

    public function WO(){
        return $this->belongsTo('App\WO'); 
     }
}
