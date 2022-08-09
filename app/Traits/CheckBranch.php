<?php

namespace App\Traits;

use App\Enums\AccountRole;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

trait CheckBranch
{
    /**
     * @param $model
     * @return void
     */
    public function checkBranch($model)
    {
        if (Auth::user()->role->value == AccountRole::SUPER_ADMIN) {
            return;
        }
        $branchId = get_class($model) == Branch::class ? $model->id : $model->branch->id;
        abort_if(Auth::user()->branch_id !== $branchId, 403, __('messages.common.forbidden'));
    }
}
