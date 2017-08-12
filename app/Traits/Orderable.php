<?php

namespace App\Traits;

trait Orderable
{

    // get latest video first
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at','desc');
    }

    
}
