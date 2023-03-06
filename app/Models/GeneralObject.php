<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralObject extends Model
{

    public function scopeLatestOrder($query) {
        $query->latest('order');
    }

    public function scopeOrder($query) {
        $query->orderBy('order', 'ASC');
    }
    
}
