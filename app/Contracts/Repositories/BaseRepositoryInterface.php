<?php

namespace App\Contracts\Repositories;

interface BaseRepositoryInterface 
{

    /**
     * Set the query limit.
     *
     * @param  int  $limit
     * @return $this
     */
    public function limit($limit);

    /**
     * Set an ORDER BY clause.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');
    /**
     * [Set elequent scopes __call]
     *
     * @param mixed $method
     * @param mixed $args
     * 
     * @return [type]
     * 
     */
    public function __call($method, $args);

    /**
     * [General queries ]
     * 
     * @return [type]
     * 
     */
    public function first($columns = ['*']);

    public function firstOrNew(array $attributes = []);

    public function firstOrCreate(array $attributes = []);

    public function find(int $id, array $columns = ['*']);
    public function findByField(string $field, $value = null, array $columns = ['*']);
    public function findWhereIn(array $field, array $values, array $columns = ['*']);

    public function findWhereNotIn(array $field, array $values, array $columns = ['*']);
    public function findWhereBetween(array $field, array $values, array $columns = ['*']);

    public function all(array $columns = ['*']);
    public function pluck(array $column, array $key = null);


     /**
     * Get all the specified model records in the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get();


    /**
     * @param  int  $limit
     * @param  array  $columns
     * @param  string  $pageName
     * @param  null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * @param $item
     * @param $column
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByColumn($column, $value, array $columns = ['*']);

    /**
     * Get the specified model record from the database.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id);

    /**
     * get Indexed data.
     *
     * @return $this
     */
    public function index(array $filters = [], $paginate = false, $limit = 25, $page = null, $pageName = 'page');

    /**
     * [Get Model]
     *
     * @param mixed $data
     *
     * @return [type]
     *
     */
    public  function getModel($identifier, $options = [], $callback = null);
    /**
     * [Description for create]
     *
     * @param mixed $data
     *
     * @return [type]
     *
     */
    public function store($data);

    /**
     * @param array $update
     * @param int $id
     * @return Bool
     */
    public function update($identifier, $data , $options = [], $callback = null);

    /**
     * [Description for delete]
     *
     * @param mixed $id
     * @param array $filters
     *
     * @return [type]
     *
     */
    public function destroy($identifier, $options = [], $callback = null);

    /**
     * [Description for multiple delete]
     *
     * @param mixed $ids
     * @param array $filters
     *
     * @return [type]
     *
     */
    public function destroyMultiple($values,$options = [], $callback = null);
}