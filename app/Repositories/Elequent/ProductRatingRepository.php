<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\ProductRatingRepositoryInterface;
use App\Models\ProductRating;
use App\Traits\TranslationRepositoryTrait;

class ProductRatingRepository extends BaseRepository  implements ProductRatingRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = ProductRating::class;

    /**
     * [Store ProductRating]
     *
     * @param array $data
     *
     * @return ProductRating $productRating
     *
     */
    public function store($data){
        return Parent::store($data);
    }
}