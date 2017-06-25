<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Attribute\ResourceAttribute;
use App\Models\Heritage\Traits\Columns\Uuids;

class HeritageResource extends \Orientdb
{
    use ResourceAttribute, Uuids;

    protected $connection = 'orientdb';
    protected $table = 'HeritageResources';
    protected $fillable = [
        'name',
        'description',
    ];

    public function has_type()
    {
        return $this->hasOne(\App\Models\Heritage\ResourceClassificationType::class, \App\Models\Heritage\Has::class);
    }
}
