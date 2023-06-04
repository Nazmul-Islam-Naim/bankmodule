<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\PropertyRepositoryInterface;
use App\Models\Property;

class PropertyRepository extends BaseRepository implements PropertyRepositoryInterface
{
    public $model = Property::class;
}
