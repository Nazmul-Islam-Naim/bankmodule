<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

/**
 * Summary of CustomerRepository
 */
class CustomerRepository extends BaseRepository  implements CustomerRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Customer::class;


    /**
     * register
     *
     * @param  mixed $data
     * @return void
     */
    public function registration($data){
        return Parent::store($data);
    }

    /**
     * [Store Customer]
     *
     * @param array $data
     *
     * @return Customer $customer
     *
     */
    public function store($data){
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::store($data), function($brnad) use($translations){
            foreach($translations as $translation){
            $brnad->translations()->create($translation);
            }
        });
    }

}
