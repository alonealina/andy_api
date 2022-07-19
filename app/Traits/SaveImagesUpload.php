<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait SaveImagesUpload
{
    /**
     * @param $data
     * @return array
     */
    public function storeImages($data): array
    {
        if (!isset($data['images'])) return [];
        $dataReturn = [];
        foreach ($data['images'] as $key => $file) {
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
     * @param $images
     * @return void
     */
    public function deleteImagesCloud($images)
    {
        foreach ($images as $image) {
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
        $fileName = explode("/", $path)[2];
        return [
            'file_name' => $fileName,
            'order' => $key
        ];
    }


    /**
     * @param $cast
     * @param $data
     * @return void
     */
    public function updateImages($model, $data)
    {
        if (!isset($data['images'])) {
            $this->deleteImages($model);
            return;
        }
        $oldImages = $model->images;
        $saveImages = [];
        foreach ($data['images'] as $key => $newImage) {
            $record = $oldImages->where('file_name', $newImage['file_name'])->first();
            if (!empty($record)) {
                $record->order = $key;
                $record->save();
                $saveImages[] = $newImage['file_name'];
            } else {
                $model->images()->create($this->saveImagesToDisk($key, $newImage['file']));
            }
        }
        $this->deleteImagesCloud($oldImages->whereNotIn('file_name', $saveImages));
    }
}
