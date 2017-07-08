<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;

class Description extends \Orientdb
{
    use Uuids;

    protected $connection = 'orientdb';
    protected $table = 'Description';
    protected $fillable = [
        'uuid',
        'description'
    ];

    public function heritageResource()
    {
        return $this->belongsTo(HeritageResource::class, HasClassificationType::class);
    }
}
