<?php
namespace App\Repositories\Elequent;


use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface {
	use TranslationRepositoryTrait;



	public $model = Order::class;



	public function store($data){
		return Parent::store($data);
	}






}