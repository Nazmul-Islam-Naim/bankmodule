<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\WishListRepositoryInterface;
use App\Models\WishList;
use App\Traits\TranslationRepositoryTrait;

class WishListRepository extends BaseRepository implements WishListRepositoryInterface {
	
	use TranslationRepositoryTrait;


	public $model = WishList::class;


	public function store($data){
        return Parent::store($data);
    }




}