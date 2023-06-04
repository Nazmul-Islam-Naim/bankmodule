<?php
namespace App\Repositories\Elequent;



use App\Contracts\Repositories\CouponRepositoryInterface;
use App\Models\Coupon;
use App\Traits\TranslationRepositoryTrait;



class CouponRepository extends BaseRepository implements CouponRepositoryInterface {
	
	use TranslationRepositoryTrait;




	
	public $model = Coupon::class;


	public function store($data){
        return Parent::store($data);
    }




}