<?php

namespace App\Models;

use App\Models\GeneralObject;
use App\Models\Group;

class Block extends GeneralObject
{
    protected $table = 'blocks';
    protected $with = ['groups'];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function scopeArchive($query)
    {
        $query->whereArchive(true);
    }

    public function scopeActive($query)
    {
        $query->whereArchive(false);
    }
}
