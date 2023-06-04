<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\VariantRepositoryInterface;
use App\Models\Variant;
use App\Traits\TranslationRepositoryTrait;
class VariantRepository extends BaseRepository  implements VariantRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Variant::class;

}
