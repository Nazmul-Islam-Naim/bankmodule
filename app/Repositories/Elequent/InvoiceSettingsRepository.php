<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\FlashSaleRepositoryInterface;
use App\Contracts\Repositories\InvoiceSettingsRepositoryInterface;
use App\Models\InvoiceSettings;


class InvoiceSettingsRepository extends BaseRepository implements InvoiceSettingsRepositoryInterface {

	public $model = InvoiceSettings::class;



}
