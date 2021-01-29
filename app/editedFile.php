<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class editedFile extends Model
{
    protected $table = 'edited_files';
   
    public function project_sourceFile(){
        return $this->belongsTo('App\project_sourceFile');
    }
    public function finalizedFile(){
        return $this->hasOne('App\finalizedFile', 'editedFile_id');
    }

}
