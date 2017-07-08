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
        'uuid',
    ];

    public function hasClassificationType()
    {
        return $this->hasOne(ResourceClassificationType::class, HasClassificationType::class);
    }

    public function hasNote()
    {
        return $this->hasOne(Description::class, HasNote::class);
    }
}
