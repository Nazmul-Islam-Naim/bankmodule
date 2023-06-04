<?php
namespace App\Repositories\Elequent;

use App\Contracts\Repositories\VoucherRepositoryInterface;
use App\Models\Voucher;
use App\Traits\TranslationRepositoryTrait;




class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface{
	use TranslationRepositoryTrait;

	public $model = Voucher::class;



	
	public function store($data){

		return Parent::store($data);
	}

}