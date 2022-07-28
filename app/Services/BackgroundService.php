<?php

namespace App\Services;

use App\Enums\AccountRole;
use App\Repositories\BackgroundRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BackgroundService
{
    protected $backgroundRepository;

    /**
     * @param BackgroundRepository $backgroundRepository
     */
    public function __construct(BackgroundRepository $backgroundRepository)
    {
        $this->backgroundRepository = $backgroundRepository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->backgroundRepository->getList();
    }

    /**
     * @param $data
     * @return bool|null
     */
    public function store($data): ?bool
    {
        $oldImages = $this->backgroundRepository->getOldImages();
        if (empty($data['images'])) {
            $this->deleteImages($oldImages);
            return true;
        }
        $saveImages = [];
        foreach ($data['images'] as $key => $newImage) {
            $record = $oldImages->where('file_name', $newImage['file_name'])->first();
            if (!empty($record)) {
                $record->role_background = AccountRole::ADMIN;
                $record->position = $newImage['position'];
                $record->save();
                $saveImages[] = $newImage['file_name'];
            } else {
                $this->backgroundRepository->create($this->saveImagesToDisk($newImage['position'],
                    $newImage['file']));
            }
        }
        if (!empty($saveImages)) {
            $this->deleteImagesCloud($oldImages->whereNotIn('file_name', $saveImages));
        }
        return true;
    }

    /**
     * @param $position
     * @param UploadedFile $file
     * @return array
     */
    public function saveImagesToDisk($position, UploadedFile $file): array
    {
        $path = Storage::disk()->put(IMAGES_PATH, $file);
        $fileName = explode("/", $path)[2];
        return [
            'file_name' => $fileName,
            'position' => $position,
            'role_background' => AccountRole::ADMIN,
        ];
    }

    /**
     * @param $oldImages
     * @return void
     */
    public function deleteImages($oldImages)
    {
        foreach ($oldImages as $oldImage) {
            Storage::disk()->delete(IMAGES_PATH . '/' . $oldImage['file_name']);
            $oldImage->forceDelete();
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
}
