<?php
namespace App\Repositories\Elequent;

use App\Contracts\Repositories\ShippingRepositoryInterface;
use App\Models\Shipping;
use App\Traits\TranslationRepositoryTrait;




class ShippingRepository extends BaseRepository implements ShippingRepositoryInterface {
	
	use TranslationRepositoryTrait;

	public $model = Shipping::class;



	
	public function store($data){

		return Parent::store($data);
	}

}