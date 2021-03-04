<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class improvedFiles extends Model
{
    protected $table = "improved_files";
    public function vendorDelivery(){
        return $this->belongsTo('App\vendorDelivery','deliveryFile_id');
    } 
}
