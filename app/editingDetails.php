<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class editingDetails extends Model
{
    //
    protected $table = 'linked_editing_stage';

    public function projects(){
        return $this->belongsTo('App\projects','project_id'); 
     }
     public function User(){
        return $this->belongsTo('App\User','editor_id'); 
     }
}
