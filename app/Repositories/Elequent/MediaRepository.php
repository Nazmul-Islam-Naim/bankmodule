<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\MediaRepositoryInterface;
use App\Models\Media;

class MediaRepository extends BaseRepository  implements MediaRepositoryInterface
{
    public $model = Media::class;



}
