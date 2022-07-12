<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait CheckStore
{
    /**
     * @param $model
     * @return void
     */
    public function checkStore($model)
    {
        abort_if(Auth::user()->store_id !== $model->store->id, 403, __('messages.common.forbidden'));
    }
}
