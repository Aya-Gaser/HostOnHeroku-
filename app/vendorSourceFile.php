<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorSourceFile extends Model
{
    protected $table = 'vendor_source_file';

    public function project(){
        return $this->belongsTo('App\projects'); 
     }
}
