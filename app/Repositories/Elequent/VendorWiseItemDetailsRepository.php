<?php
namespace App\Repositories\Elequent;



use App\Contracts\Repositories\OrderDetailsRepositoryInterface;
use App\Contracts\Repositories\VendorWiseItemDetailsRepositoryInterface;
use App\Models\OrderDetail;
use App\Models\VendorWiseItemDetails;
use App\Traits\TranslationRepositoryTrait;



class VendorWiseItemDetailsRepository extends BaseRepository implements VendorWiseItemDetailsRepositoryInterface {
	
	use TranslationRepositoryTrait;




	
	public $model = VendorWiseItemDetails::class;


	public function store($data){
        return Parent::store($data);
    }




}