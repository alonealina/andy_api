<?php

namespace App\Traits;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;

trait CheckStore
{
    /**
     * @param $model
     * @return void
     */
    public function checkStore($model)
    {
        $storeId = get_class($model) == Store::class ? $model->id : $model->store->id;
        abort_if(Auth::user()->store_id !== $storeId, 403, __('messages.common.forbidden'));
    }
}
