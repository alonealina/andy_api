<?php

namespace App\Services;

use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\DB;

class NewsService
{
    /**
     * @var NewsRepository
     */
    protected $newsRepository;

    /**
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->newsRepository->getList();
    }

    /**
     * @param News $news
     * @return array
     */
    public function show(News $news): array
    {
        return $news->with('branches:id,name')->get()->toArray();
    }

    /**
     * @param $params
     * @return bool|null
     */
    public function store($params): ?bool
    {
        DB::beginTransaction();
        try {
            $news = $this->newsRepository->create([
                'title' => $params['title'],
                'content' => $params['content']
            ]);
            $news->branches()->sync($params['branch_ids']);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param News $news
     * @return mixed|null
     */
    public function delete(News $news)
    {
        $news->delete();
        return $news;
    }

    /**
     * @param $params
     * @param News $news
     * @return bool|null
     */
    public function update($params, News $news): ?bool
    {
        DB::beginTransaction();
        try {
            $news->update([
                'title' => $params['title'],
                'content' => $params['content']
            ]);
            $news->branches()->sync($params['branch_ids']);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
