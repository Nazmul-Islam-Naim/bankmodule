<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\BrandRepositoryInterface;
use App\Contracts\Repositories\TransactionInterface;
use App\Models\Brand;
use App\Models\Transaction;
use App\Services\Service;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class TransactionRepository extends BaseRepository  implements TransactionInterface
{
    use TranslationRepositoryTrait;

    public $model = Transaction::class;

}