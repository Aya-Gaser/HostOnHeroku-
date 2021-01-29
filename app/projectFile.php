<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectFile extends Model
{
    protected $table= 'project_files';
 
    public function projects(){
        return $this->belongsTo('App\projects'); 
     }
}
