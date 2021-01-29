<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    //

    protected $table = 'clients';

    public function Wo(){
        return $this->hasMany('App\WO');
    }

}
