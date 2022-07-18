<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CommonScopeModel
{
    /**
     * Scope check store
     *
     * @param $query
     * @return void
     */
    public function scopeBelongsToBranch($query)
    {
        $query->where('branch_id', Auth::user()->branch_id);
    }
}
