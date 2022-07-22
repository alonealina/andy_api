<?php

namespace App\Services;

use App\Models\News;
use App\Repositories\NewsRepository;

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
     * @param $params
     * @return mixed|null
     */
    public function store($params)
    {
        return $this->newsRepository->store($params);
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
     * @return News
     */
    public function update($params, News $news): News
    {
        $news->update($params);
        return $news;
    }
}
