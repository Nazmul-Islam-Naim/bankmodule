<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Models\Address;


class AddressRepository extends BaseRepository  implements AddressRepositoryInterface
{

    public $model = Address::class;


}
