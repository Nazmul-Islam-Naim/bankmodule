<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\LegalFormRepositoryInterface;
use App\Models\LegalForm;

class LegalFormRepository extends BaseRepository  implements LegalFormRepositoryInterface
{
    public $model = LegalForm::class;
}