<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\HeritageResourceType;
use App\Models\Heritage\StreetName;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StreetNameRepository.
 */
class StreetNameRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->model = $this->entityManager->getRepository(StreetName::class);
    }

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        $heritageResourceTypes = $this->model->findAll();

        $results = [];
        foreach ($heritageResourceTypes as $k => $heritageResourceType) {
            $results[$k]['id'] = $heritageResourceType->getId();
            $results[$k]['type_set'] = $heritageResourceType->getTypeSet();
            $results[$k]['type'] = $heritageResourceType->getType();
            $results[$k]['published'] = $heritageResourceType->getPublished();
            $results[$k]['created_at'] = $heritageResourceType->getCreatedAt();
            $results[$k]['updated_at'] = $heritageResourceType->getUpdatedAt();
            $results[$k]['actions'] = $heritageResourceType->getActionButtonsAttribute();
        }

        return $results;
    }

    /**
     * @param Model $input
     */
    public function create($input)
    {
    }
}
