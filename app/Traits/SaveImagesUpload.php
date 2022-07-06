<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait SaveImagesUpload
{
    /**
     * @param $files
     * @return array
     */
    public function storeImages($files): array
    {
        $dataReturn = [];
        $files = is_array($files) ? $files : array($files);
        foreach ($files as $key => $file) {
            $dataReturn[] = $this->saveImagesToDisk($key, $file);
        }
        return $dataReturn;
    }

    /**
     * @param $model
     * @return void
     */
    public function deleteImages($model)
    {
        foreach ($model->images as $image) {
            Storage::disk()->delete(IMAGES_PATH . '/' . $image->file_name);
            $image->forceDelete();
        }
    }

    /**
     * @param $key
     * @param UploadedFile $file
     * @return array
     */
    public function saveImagesToDisk($key, UploadedFile $file): array
    {
        $path = Storage::disk()->put(IMAGES_PATH, $file);
        $fileName = explode("/", $path)[1];
        return [
            'file_name' => $fileName,
            'order' => $key
        ];
    }
}
