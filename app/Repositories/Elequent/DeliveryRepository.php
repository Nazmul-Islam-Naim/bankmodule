<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\DeliveryRepositoryInterface;
use App\Models\Delivery;
use App\Traits\TranslationRepositoryTrait;

/**
 * Summary of CustomerRepository
 */
class DeliveryRepository extends BaseRepository  implements DeliveryRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Delivery::class;




    //filters

    public function active($query){
        $query->where('status',true);
    }
}
