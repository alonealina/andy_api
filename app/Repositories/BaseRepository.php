<?php

/**
 * PHP version 7.4
 *
 * @package   App\Repositories
 * @author    Do Phu Cuong <cuongdp@hblab.vn>
 * @link      https://laravel.com Laravel(tm) Project
 */

namespace App\Repositories;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * The repository model.
     *
     * @var Model
     */
    protected $model;

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected $query;

    /**
     * Alias for the query limit.
     *
     * @var int
     */
    protected $take;

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    private $with = [];

    /**
     * Array of one or more where clause parameters.
     *
     * @var array
     */
    private $wheres = [];

    /**
     * Array of one or more where in clause parameters.
     *
     * @var array
     */
    private $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs.
     *
     * @var array
     */
    private $orderBys = [];

    /**
     * Array of scope methods to call on the model.
     *
     * @var array
     */
    private $scopes = [];

    /**
     * BaseRepository constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * Make model.
     *
     * @return Model
     * @throws BindingResolutionException
     */
    public function makeModel(): object
    {
        $model = app()->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of " . Model::class);
        }

        return $this->model = $model;
    }

    /**
     * Count the number of specified model records in the database.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->get()->count();
    }

    /**
     * Create multiple data.
     *
     * @param array $data
     * @return Collection
     */
    public function createMultiple(array $data)
    {
        $models = new Collection();

        foreach ($data as $d) {
            $models->push($this->store($d));
        }

        return $models;
    }

    /**
     * Create a record.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        $this->unsetClauses();

        return $this->model->create($data);
    }

    /**
     * Delete by id.
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool
    {
        $this->unsetClauses();

        return $this->getById($id)->delete();
    }

    /**
     *  Delete multiple records.
     *
     * @param array $ids
     * @return int
     */
    public function deleteMultipleById(array $ids): int
    {
        return $this->model->destroy($ids);
    }

    /**
     * Delete one or more model records from the database.
     *
     * @return mixed
     */
    public function delete()
    {
        $this->newQuery()->setClauses()->setScopes();

        $result = $this->query->delete();

        $this->unsetClauses();

        return $result;
    }

    /**
     * Get the first specified model record from the database.
     *
     * @param array $columns
     * @return Builder|Model
     */
    public function first(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->firstOrFail($columns);

        $this->unsetClauses();

        return $model;
    }

    /**
     * Get all the specified model records in the database.
     *
     * @param array $columns
     * @return Builder[]|Collection
     */
    public function get(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get($columns);

        $this->unsetWith();
        $this->unsetClauses();

        return $models;
    }

    /**
     * Get the specified model record from the database.
     *
     * @param $id
     * @param array $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id, array $columns = ['*'])
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        $model = $this->query->findOrFail($id, $columns);

        $this->unsetWith();

        return $model;
    }

    /**
     * Create a new instance of the model's query builder.
     *
     * @return $this
     */
    protected function newQuery()
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load.
     *
     * @return $this
     */
    protected function eagerLoad()
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder.
     *
     * @return $this
     */
    protected function setClauses()
    {
        foreach ($this->wheres as $where) {
            $this->query->where(
                $where['column'],
                $where['operator'],
                $where['value']
            );
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (isset($this->take) and !is_null($this->take)) {
            $this->query->take($this->take);
        }

        return $this;
    }

    /**
     * Set query scopes.
     *
     * @return $this
     */
    protected function setScopes()
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(implode(', ', $args));
        }

        return $this;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param $column
     * @param $value
     * @param string $operator
     * @return $this
     */
    public function where($column, $value, string $operator = '=')
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query.
     *
     * @param $column
     * @param $values
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : array($values);

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load.
     *
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        if (is_string($relations)) {
            $relations = explode(',', $relations);
        }

        $this->with = $relations;

        return $this;
    }

    /**
     *  Set an ORDER BY clause.
     *
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, string $direction = 'asc')
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Set the query limit.
     *
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Reset the query clause parameter arrays.
     *
     * @return $this
     */
    protected function unsetClauses()
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->scopes = [];
        $this->take = null;

        return $this;
    }

    /**
     * Reset the query with arrays.
     *
     * @return $this
     */
    protected function unsetWith()
    {
        if (!empty($this->with)) {
            $this->with = [];
        }

        return $this;
    }

    /**
     * Get all.
     *
     * @return Collection|Model[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Find record.
     *
     * @param $id
     * @param $withTrashed
     * @return mixed
     */
    public function find($id, $withTrashed = false)
    {
        return $this->model
            ->when($withTrashed, function ($query) {
                $query->withTrashed();
            })
            ->find($id);
    }

    /**
     * Create record.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update record by id.
     *
     * @param $id
     * @param array $attributes
     * @return false|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    /**
     * Find or fail.
     *
     * @param $id
     * @param $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     *  Generates pagination.
     *
     * @param $items
     * @param $perPage
     * @param $page
     * @return LengthAwarePaginator
     */
    public function generatesPaginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collect::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    }
}
