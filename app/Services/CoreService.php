<?php
namespace App\Services;

use App\Enum\Message;
use App\Exceptions\GeneralException;
use App\Helpers\Helper;
use App\Traits\DBTSTRAIT;
use App\Traits\ExceptionTrait;
use App\Traits\FSMTRAIT;
use App\Traits\ServiceActionTrait;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CoreService
{
    use ServiceActionTrait;
    use DBTSTRAIT;
    use FSMTRAIT;
    use ExceptionTrait;


    public $repository;

    public $encryptedId = false;

    protected $name;

    public $dispatchRules=['data'];

    protected $decryptable=[];

    protected $slugables=[];



    /**
     * [Description for get]
     *
     * @param Array $filters=[]
     * @param mixed $paginate=false
     * @param int $limit
     * @param null $page
     * @param string $pageName
     *
     * @return [type]
     *
     */
    public function index(Array $options=[],$paginate=false,$limit = 25, $page = null, $pageName = 'page')
    {
        try{
            return $this->repository->index($options, $paginate, $limit, $page, $pageName);
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

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

        try{
            $model =  $this->repository->store($data);
            $this->setServiceValues(['model'=>$model, 'data'=>$data])->serviceEvent();
            return $model ;
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

    }


    /**
     * [Description for show]
     *
     * @param mixed $id
     * @param array $filters
     *
     * @return [type]
     *
     */
    public function show($identifier, $options = [], $callback = null){
        try{
            return $this->repository->getModel($identifier, $options, $callback);
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

    }


     /**
     * @param array $update
     * @param int $id
     * @return Bool
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        try{
            $model = $this->repository->update($identifier, $data, $options, $callback);
            $this->setServiceValues(['model'=>$model, 'data'=>$data])->serviceEvent();
            return $model;
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

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
    public function destroy($identifier, $options = [], $callback = null){
        try{
            $model = $this->repository->destroy($identifier, $options, $callback);
            $this->setServiceValues(['model'=>$model])->serviceEvent();
            return $model;
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

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
    public function destroyMultiple($data, $options = [], $callback = null){
        if($this->encryptedId){
            $data = array_map(function($id){
                return Helper::decrypt($id);
            },$data);
        }
        try{
            $status =  $this->repository->destroyMultiple($data, $options, $callback);
            $this->setServiceValues(['properties'=>$data])->serviceEvent();
            return $status;
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }
    }


   /**
    * [Description for forceDelete]
    *
    * @param integer $indentifier
    * @param array $options
    * @param function $callback
    *
    * @return [type]
    *
    */
    public function forceDelete($identifier, $options = [], $callback = null){
        try{
            $model = $this->repository->forceDelete($identifier, $this->mergeFilters($options, ['trashed']), $callback);
            $this->setServiceValues(['model'=>$model])->serviceEvent();
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

   }


   /**
    * restore  trashed data
    * @param mixed $identifier
    * @return mixed
    */
   public function restore($identifier, $options = [], $callback = null)
   {
        try{
            $model = $this->repository->restore($identifier, $this->mergeFilters($options, ['trashed']), $callback);
            $this->setServiceValues(['model'=>$model])->serviceEvent();
            return $model;
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

   }

   /**
    * Restore all trashed data
    * @return mixed
    */
   public function restoreAll($options = [])
   {
        try{
            $this->repository->restoreAll($this->mergeFilters($options, ['trashed']));
            $this->setServiceValues()->serviceEvent();
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

   }

    /**
    * Restore all trashed data
    * @return mixed
    */
    public function emptyTrash($options = [])
    {
        try{
            $this->repository->emptyTrash($this->mergeFilters($options, ['trashed']));
            $this->setServiceValues()->serviceEvent();
        }catch(Exception $exception){
            throw new GeneralException($exception,$this->getExceptionMessage());
        }

    }


    /**
     * getExceptionMessage
     *
     * @return void
     */
    public function getExceptionMessage(){
        $method = $this->getMethodName(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function']);
        if($enum = Message::tryFrom($method)){
            return $this->getName($enum).' '.$enum->description()['exception'];
        }
    }


    /**
    * Get method name
    * @param mixed $method
    * @return mixed
    */
    public function getMethodName($method){
        if($method == "destroy"  && $this->repository->hasSoftDelete()){
            return "trashed";
        }

        if($method == "store"){
            return "create";
        }
        return $method;
    }


    /**
    * Convert service method name
    * @param mixed $enum
    * @return mixed
    */
    public function getName($enum){
        return $enum->description()['type'] =="plural"?Str::plural($this->name):$this->name;
    }


    /**
    * Merge filters
    * @param array $options
    * @param array $filters
    */
    public function mergeFilters($options, array $filters){
        if(Arr::has($options,'filters')){
            $options['filters'] = array_merge($filters, $options['filters']);
        }else{
            $options['filters'] = $filters;
        }
        return $options;
    }

    /**
     * get boolean for soft delete
     *
     * @return bool
     */
    public function hasSoftdelete(){
        return Helper::hasSoftDelete($this->repository->model);
    }


     /**
     * get boolean for Translation.
     *
     * @return bool
     */
    public function hasTranslation(){
        return Helper::hasTranslation($this->repository->model);
    }


     /**
     * modify for Translation data array.
     *
     * @return Object
     */
    public function mapTranslationData(&$data){
        if( Arr::has($data , 'translations')){
            $mapped = Arr::map($data['translations'], function (array $value, string $key) {
                $value['local'] = $key;
                return $value;
            });

            $data['translations'] = $mapped;
        }

        return $this;
    }


    /**
     *Dycrypt id
     *
     */
    public function decrypter(&$data){

        foreach($this->decryptable as $item){
            if(Arr::has($data,$item)){
                $data[$item] = Crypt::decryptString($data[$item]);
            }
        }
        return $this;
    }

    public function slugToId(&$data){

        foreach($this->slugables as $key=>$slug){
            if(Arr::has($data,$key)){
                logger()->error([$slug,$data[$key]]);
                $data[$key] = $this->repository->slugable($slug,$data[$key])->id;
            }
        }
        return $this;
    }

    /**
     * filterdata
     *
     * @param  mixed $data
     */
    protected function filterdata(&$data){
        $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');
        return $this;
    }

    /**
     * methodReover
     *
     * @param  mixed $data
     */
    protected function methodRemover(&$data){
       if(Arr::has($data,'_method')){
        Arr::pull($data,'_method');
       }
        return $this;
    }




    /**
     *The rules willbe call fro, service dispatcher
     *
     * @return array
     */
    public function dataRules($data){
        $this->filterdata($data)->decrypter($data)->slugToId($data)->methodRemover($data);

        return $data;
    }



}
