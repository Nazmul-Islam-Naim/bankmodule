<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\BusinessInfoRepositoryInterface;
use App\Models\Address;
use App\Models\BusinessInfo;

class BusinessInfoRepository extends BaseRepository  implements BusinessInfoRepositoryInterface
{

    public $model = BusinessInfo::class;

}
