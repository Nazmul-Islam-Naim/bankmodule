<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\ProductAttributeInterface;
use App\Models\ProductAttribute;

class ProductAttributeRepository extends BaseRepository  implements ProductAttributeInterface
{
    public $model = ProductAttribute::class;

}
