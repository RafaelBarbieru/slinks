<?php

namespace App\Models;

use App\Models\GeneralObject;
use App\Models\Group;

class Link extends GeneralObject
{
    protected $table = 'links';
    protected $with = ['group'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
