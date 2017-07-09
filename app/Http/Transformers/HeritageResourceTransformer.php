<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Heritage\HeritageResource;

class HeritageResourceTransformer extends TransformerAbstract
{
    public function transform(HeritageResource $heritageResource)
    {
        return [
            'id' => (int) $heritageResource->getId(),
            'uuid' => (string) $heritageResource->getUuid(),
            'description' => (string) $heritageResource->getDescription(),
        ];
    }
}