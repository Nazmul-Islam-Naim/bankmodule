<?php
namespace App\Repositories\Elequent;



use App\Contracts\Repositories\OrderDetailsRepositoryInterface;
use App\Models\OrderDetail;
use App\Traits\TranslationRepositoryTrait;



class OrderDetailsRepository extends BaseRepository implements OrderDetailsRepositoryInterface {
	
	use TranslationRepositoryTrait;




	
	public $model = OrderDetail::class;


	public function store($data){
        return Parent::store($data);
    }




}