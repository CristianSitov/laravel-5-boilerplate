<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;

class HeritageResourceClassificationType
{
    use Uuids;

    public function heritageResource()
    {
        return $this->belongsTo(HeritageResource::class, HasClassificationType::class);
    }
}
