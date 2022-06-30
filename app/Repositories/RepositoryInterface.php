<?php

/**
 * PHP version 7.4
 *
 * @package   App\Repositories
 * @author    Do Phu Cuong <cuongdp@hblab.vn>
 * @link      https://laravel.com Laravel(tm) Project
 */

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all data.
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Find by id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create data.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update data.
     *
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Get count.
     *
     * @return mixed
     */
    public function count();

    /**
     * Create multiple data.
     *
     * @param array $data
     * @return mixed
     */
    public function createMultiple(array $data);

    /**
     * Create data.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * Delete by id.
     *
     * @param $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * Delete many by id.
     *
     * @param array $ids
     * @return mixed
     */
    public function deleteMultipleById(array $ids);

    /**
     * Delete one or more model records from the database.
     *
     * @return mixed
     */
    public function delete();

    /**
     * Get the first specified model record from the database.
     *
     * @param array $columns
     * @return mixed
     */
    public function first(array $columns = ['*']);

    /**
     * Get all data.
     *
     * @param array $columns column name
     *
     * @return mixed
     */
    public function get(array $columns = ['*']);

    /**
     * Get by id.
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function getById($id, array $columns = ['*']);

    /**
     * Find or fail.
     *
     * @param $id
     * @return mixed
     */
    public function findOrFail($id);

    /**
     * Add a simple where clause to the query.
     *
     * @param $column
     * @param $value
     * @param string $operator
     * @return mixed
     */
    public function where($column, $value, string $operator = '=');
}
