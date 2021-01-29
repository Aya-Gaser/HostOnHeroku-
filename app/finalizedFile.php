<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class finalizedFile extends Model
{
    protected $table = 'finalized_files';

    public function project_sourceFile(){
        return $this->belongsTo('App\project_sourceFile');
    }
    public function projects(){
        return $this->belongsTo('App\projects');
    }
}
