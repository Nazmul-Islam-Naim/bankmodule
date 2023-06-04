<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\OptionRepositoryInterface;
use App\Models\Option;

class OptionRepository extends BaseRepository  implements OptionRepositoryInterface
{
    public $model = Option::class;
}
