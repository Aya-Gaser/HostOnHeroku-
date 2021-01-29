<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectsInvitations extends Model
{
    protected $table = 'project_invitations';
    protected $fillable =['project_id','vendor_id', 'group'];
}
