<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CommonTraitModel
{
    /**
     * Scope check store
     *
     * @param $query
     * @return void
     */
    public function scopeBelongsToStore($query)
    {
        $query->where('store_id', Auth::user()->store_id);
    }
}
