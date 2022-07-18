<?php

namespace App\Services;

use App\Repositories\BackgroundRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackgroundService
{
    protected $backgroundRepository;

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
     * @param $params
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public function store($params)
    {
        $file_names = array_column($params['background'], 'file_name');
        $keepFiles = $this->getFiles($params['background'], 'file_name');
        $newFiles = $this->getFiles($params['background'], 'file');
        $allBackground = $this->backgroundRepository->where('branch_id', Auth::user()->branch_id);

        DB::beginTransaction();
        try {
            if (!empty($keepFiles)) {
                $updateRecords = $allBackground->whereIn('file_name', array_column($keepFiles, 'file_name'))->get();
                foreach ($updateRecords as $updateRecord) {
                    $updateRecord->position = $keepFiles[
                        array_search($updateRecord->file_name, array_column($keepFiles, 'file_name'))]['position'];

                    $updateRecord->save();
                }
            }

            if (!empty($newFiles)) {
                $deleteBackgrounds = $this->backgroundRepository->whereNotIn('file_name', $file_names);
                $this->deleteImages($deleteBackgrounds->get());
                $deleteBackgrounds->delete();

                foreach ($newFiles as $newFile) {
                    $file_name = $this->saveImagesToDisk($newFile['file']);
                    $this->backgroundRepository->store([
                        'file_name' => $file_name,
                        'position' => $newFile['position']
                    ]);
                }
            }
            DB::commit();
            return $allBackground->get();
        } catch (\Exception $exception) {
            report($exception);
            DB::rollback();
            return null;
        }
    }

    /**
     * @param UploadedFile $file
     * @return mixed|string
     */
    public function saveImagesToDisk(UploadedFile $file)
    {
        $path = Storage::disk()->put(IMAGES_PATH, $file);
        return explode("/", $path)[2];
    }

    /**
     * @param $array
     * @return array
     */
    public function getFiles($array, $column): array
    {
        $subArr = [];
        foreach ($array as $record) {
            if (!empty($record[$column])) {
                $subArr [] = $record;
            }
        }
        return $subArr;
    }

    /**
     * @param $backgrounds
     * @return void
     */
    public function deleteImages($backgrounds)
    {
        foreach ($backgrounds as $background) {
            Storage::disk()->delete(IMAGES_PATH . '/' . $background['file_name']);
        }
    }
}
