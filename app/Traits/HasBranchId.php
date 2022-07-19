<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasBranchId
{
    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->hasFillAble('branch_id') && self::getBranchId()) {
                $model->branch_id = self::getBranchId();
            }
        });
    }

    /**
     * @param $column
     * @return bool
     */
    public function hasFillAble($column): bool
    {
        return in_array($column, $this->fillable);
    }

    /**
     * Get branch id
     *
     * @return int
     */
    public static function getBranchId(): int
    {
        if (Auth::check()) {
            return Auth::user()->branch_id;
        }
        return 0;
    }
}
