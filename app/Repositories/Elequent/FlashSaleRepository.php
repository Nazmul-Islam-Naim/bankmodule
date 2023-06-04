<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\FlashSaleRepositoryInterface;
use App\Models\FlashSale;
use App\Traits\TranslationRepositoryTrait;

class FlashSaleRepository extends BaseRepository implements FlashSaleRepositoryInterface {
	
	use TranslationRepositoryTrait;
	public $model = FlashSale::class;


	public function store($data){
        return Parent::store($data);
    }




}