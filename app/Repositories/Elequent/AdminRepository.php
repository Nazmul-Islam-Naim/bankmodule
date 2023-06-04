<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\AdminRepositoryInterface;
use App\Enum\Status;
use App\Models\Admin;
use App\Traits\TranslationRepositoryTrait;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdminRepository extends BaseRepository  implements AdminRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Admin::class;

    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data){

        $translations = Arr::pull($data, 'translations');
        return tap(Parent::store($data), function($model) use($data,$translations){
            if($translations){
                foreach($translations as $translation){
                    $model->translations()->create($translation);
                }
            }

            if(Arr::has($data,'avatar')){
                $model->avatar()->create(['tag'=>'avatar',...$data['avatar']]);
            }
        });
    }

    /**
     * update
     *
     * @param  mixed $identifier
     * @param  mixed $data
     * @param  mixed $options
     * @param  mixed $callback
     * @return void
     */
    public function update($identifier, $data , $options = [], $callback = null){
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::update($identifier, $data , $options), function($model) use($data,$translations){

            if($translations){
                $this->deleteTranslation( $model, $translations);
            foreach($translations as $translation){
                $model->translations()->updateOrCreate(['local'=>Arr::pull($translation, 'local')],$translation);
            }
            }

            if(Arr::has($data,'avatar')){
                if($model->avatar){
                    $model->avatar->update(['tag'=>'avatar',...$data['avatar']]);
                }
                else{
                    $model->avatar()->create(['tag'=>'avatar',...$data['avatar']]);
                }
            }
        });
    }

    public function search($query, $value = null)
    {
        if ($value) {
            $query->where("phone", "Like", "%" . $value . "%")
                ->orWhere("email", "Like", "%" . $value . "%");
        }
    }

    public function status($query, $value = null)
    {
        if ($value) {
            $query->where('status',Status::getFromName($value)->value);
        }
    }
}
