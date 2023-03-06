<?php

namespace App\Models;

use App\Models\GeneralObject;
use App\Models\Block;
use App\Models\Link;

class Group extends GeneralObject
{
    protected $table = 'groups';

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
