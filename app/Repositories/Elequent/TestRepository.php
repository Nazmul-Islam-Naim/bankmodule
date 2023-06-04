<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\TestRepositoryInterface;
use App\Models\Test;

class TestRepository extends BaseRepository  implements TestRepositoryInterface
{

    public $model = Test::class;


}
