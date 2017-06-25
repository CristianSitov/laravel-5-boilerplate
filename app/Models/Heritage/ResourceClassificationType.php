<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;

class ResourceClassificationType extends \Orientdb
{
    use Uuids;

    protected $connection = 'orientdb';
    protected $table = 'ResourceClassificationType';
    protected $fillable = [
        'uuid',
        'type'
    ];
}
