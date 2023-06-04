<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\BaseRepositoryInterface;
use App\Helpers\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BaseRepository  implements BaseRepositoryInterface
{
    /**
     * ModelInstance
     */
    public $model;


    /**
     * [The base column]
     *
     * @var string
     */
    public $base = 'id';

    /**
     * The query builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * Alias for the query limit.
     *
     * @var int
     */
    protected $take;

    /**
     * callbacks.
     *
     * @var array
     */
    protected $closures = [];

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Array of filters .
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Array of one or more where clause parameters.
     *
     * @var array
     */
    protected $wheres = [];

    /**
     * Array of one or more or where in clause parameters.
     *
     * @var array
     */
    protected $orWheres = [];

    /**
     * Array of one or more where in clause parameters.
     *
     * @var array
     */
    protected $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs.
     *
     * @var array
     */
    protected $orderBys = [];

    /**
     * Array of scope methods to call on the model.
     *
     * @var array
     */
    protected $scopes = [];


    public function __construct()
    {
        $this->query = $this->model::query();
    }

    /**
     * Add a simple clause to the query.
     *
     * @param  string  $clouser
     * @return $this
     */
    public function closure($clouser)
    {
        $this->closures[] = $clouser;

        return $this;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param  string  $column
     * @param  string  $value
     * @param  string  $operator
     * @return $this
     */
    public function where($column, $value, $operator = '=')
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query.
     *
     * @param  string  $column
     * @param  mixed  $values
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Add a simple or where in clause to the query.
     *
     * @param  string  $column
     * @param  mixed  $values
     * @return $this
     */
    public function orWhere($column, $value, $operator = '=')
    {
        $this->OrWheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple filter query from model to the query.
     *
     * @param  string  $column
     * @param  mixed  $values
     * @return $this
     */
    public function filter(array $filters = [])
    {
        $this->filters = is_array($filters) ? $filters : [];

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
            $relations = func_get_args();
        }

        $this->with = $relations;

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
     * Set clousers.
     *
     * @return $this
     */
    protected function setClosure()
    {
        foreach ($this->closures as $clouser) {
            if(is_callable($clouser)){
                call_user_func($clouser, $this->query);
            }
        }
        return $this;
    }


    /**
     * Set filters to query.
     *
     * @return $this
     */
    protected function setFilter()
    {
        foreach ($this->filters as $method => $value) {

            if(is_int($method)){
                   $this->$value($this->query);
            }else{
                $this->$method($this->query, $value);
            }

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
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        foreach ($this->orWheres as $where) {
            $this->query->orWhere($where['column'], $where['operator'], $where['value']);
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
            $method = 'scope'.ucfirst($method);
            $this->$method($this->query, implode($args));
        }

        return $this;
    }

    /**
     * Set the query limit.
     *
     * @param  int  $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Set an ORDER BY clause.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * [Description for setQuery]
     *
     * @param mixed $filters
     *
     * @return [type]
     *
     */
    protected function setQuery(){
        $this->setFilter()->eagerLoad()->setClauses()->setScopes()->setClosure()->unsetClauses();
        return $this->query;
    }

    /**
     * Reset the query clause parameter arrays.
     *
     * @return $this
     */
    protected function unsetClauses()
    {
        $this->wheres   = [];
        $this->whereIns = [];
        $this->scopes   = [];
        $this->closures = [];
        $this->take     = null;

        return $this;
    }


    /**
     * [Set elequent scopes __call]
     *
     * @param mixed $method
     * @param mixed $args
     *
     * @return [type]
     *
     */
    public function __call($method, $args)
    {
        $this->scopes[$method] = $args;
        return $this;
    }

    /**
     * [General queries ]
     *
     * @return [type]
     *
     */
    public function first($columns = ['*'])
    {
        return $this->model->first($columns);
    }

    public function firstOrNew(array $attributes = [])
    {
        return $this->model->firstOrNew($attributes);
    }

    public function firstOrCreate(array $attributes = [])
    {
        return $this->model->firstOrCreate($attributes);
    }

    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function findByField(string $field, $value = null, array $columns = ['*'])
    {
        return $this->model->where($field, '=', $value)->get($columns);
    }

    public function findWhereIn(array $field, array $values, array $columns = ['*'])
    {
        return $this->model->whereIn($field, $values)->get($columns);
    }

    public function findWhereNotIn(array $field, array $values, array $columns = ['*'])
    {
        return $this->model->whereNotIn($field, $values)->get($columns);
    }

    public function findWhereBetween(array $field, array $values, array $columns = ['*'])
    {
        return $this->model->whereBetween($field, $values)->get($columns);
    }

    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function pluck(array $column, array $key = null)
    {
        return $this->model->pluck($column, $key);
    }


     /**
     * Get all the specified model records in the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        $models = $this->setQuery()->get();
        $this->unsetClauses();
        return $models;
    }


    /**
     * @param  int  $limit
     * @param  array  $columns
     * @param  string  $pageName
     * @param  null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null)
    {
        $models = $this->setQuery()->paginate($limit, $columns, $pageName, $page);

        $this->unsetClauses();

        return $models;
    }


    /**
     * @param $item
     * @param $column
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByColumn($column, $value, array $columns = ['*'])
    {
        $model = $this->setQuery()->where($column, $value)->first($columns);
        $this->unsetClauses();
        return $model;
    }

    /**
     * Get the specified model record from the database.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        $model =  $this->setQuery()->findOrFail($id);
        $this->unsetClauses();
        return $model;
    }


    public function processOptions(array $options){

        if(array_key_exists('filters', $options)){
            $this->filter($options['filters']);
        }

        if (array_key_exists('groupBy', $options)) {
            $this->query->groupBy($options['groupBy']);
        }

        if (array_key_exists('sortBy', $options)) {
            $this->query->orderBy(...$options['sortBy']);
        }

        if (array_key_exists('select', $options)) {
            $this->query->select(...$options['select']);
        }
        return $this;
    }


    /**
     * get Indexed data.
     *
     * @return $this
     */
    public function index(array $options = [], $paginate = false, $limit = 25, $page = null, $pageName = 'page')
    {
        $this->processOptions($options);
        return $paginate ? $this->paginate($limit, ['*'], $pageName, $page)->appends(request()->all()) : $this->get();
    }

    /**
     * [Get Model]
     *
     * @param mixed $data
     *
     * @return [type]
     *
     */
    public  function getModel($identifier, $options = [], $callback = null){

        $this->processOptions($options);

        if($callback){
            $this->closure($callback);
        }

        if(Arr::has($options, 'column')){
           return  $model = $this->getByColumn(Arr::has($options, 'column'), $identifier);
        }

        return $this->getById($identifier);
    }

    /**
     * [Description for create]
     *
     * @param mixed $data
     *
     * @return [type]
     *
     */
    public function store($data)
    {
        return $this->model::create($data)->fresh();
    }


    /**
     * @param array $update
     * @param int $id
     * @return Bool
     */
    public function update($identifier, $data , $options = [], $callback = null)
    {
        if(Arr::has($options, 'model')){
            $model = $options['model'];
        }else{
            $model = $this->getModel($identifier, $options, $callback);
        }
        $model->update($data);
        return $model;
    }

    /**
     * [Description for delete]
     *
     * @param mixed $id
     * @param array $filters
     *
     * @return [type]
     *
     */
    public function destroy($identifier, $options = [], $callback = null)
    {
        // print_r($identifier);
        // die();
        $model = $this->getModel($identifier, $options, $callback);
        $preserve = $model ;
        $model->delete();
        return $preserve;
    }


     /**
     * [Description for delete]
     *
     * @param mixed $id
     * @param array $filters
     *
     * @return [type]
     *
     */
    public function forcedelete($identifier, $options = [], $callback = null)
    {
        $model = $this->getModel($identifier, $options, $callback);
        $preserve = $model ;
        $model->forcedelete();
        return $preserve;
    }

     /**
     * [Restore Trashed Data]
     *
     * @param mixed $id
     * @param array $filters
     *
     * @return [type]
     *
     */
    public function restore($identifier, $options = [], $callback = null)
    {
        $model = $this->getModel($identifier, $options, $callback);
        $preserve = $model ;
        $model->restore();
        return $preserve;
    }

     /**
     * [Restoreall trashed data]
     *
     * @param array $options
     *
     */
    public function restoreAll($options = [])
    {
        return $this->processOptions($options)->setQuery()->restore();
    }


     /**
     * [empty all trashed data]
     *
     * @param array $options
     *
     */
    public function emptyTrash($options = [])
    {
        return $this->processOptions($options)->setQuery()->forceDelete();
    }

    /**
     * [Description for multiple delete]
     *
     * @param mixed $ids
     * @param array $filters
     *
     * @return [type]
     *
     */
    public function destroyMultiple($values,$options = [], $callback = null){

        $this->processOptions($options);

        if($callback){
            $this->closure($callback);
        }

        if(Arr::has($options, 'column')){
           $this->whereIn($options['column'], $values);
        }

        else{
            $this->whereIn($this->base, $values);
        }

        $status = $this->setQuery()->delete();

        $this->unsetClauses();

        return $status;

    }

    public function slugable($model,$value){
        return $model::where('slug',$value)->first();
    }

    //Filters

    /**
     * [Get Only Trashed Data]
     *
     * @return [type]
     *
     */
    public function trashed($query){
        $query->onlyTrashed();
        return $this;
    }


      /**
     * [Get with Trashed Data]
     *
     * @return [type]
     *
     */
    public function withTrash($query){
        $query->withTrashed();
        return $this;
    }


}
