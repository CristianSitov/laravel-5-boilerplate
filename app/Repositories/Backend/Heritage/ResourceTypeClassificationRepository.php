<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\ResourceTypeClassification;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResourceRepository.
 */
class ResourceTypeClassificationRepository extends BaseRepository
{
    /**
     * import process script
     * LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E55.ResourceClassificationType_01.csv" AS row CREATE (n:ResourceTypeClassification)
     * SET n = row,
     * n.uuid = row.uuid,
     * n.type = row.type,
     * n.created = row.created,
     * n.updated = row.updated;
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->model = $this->entityManager->getRepository(ResourceTypeClassification::class);
    }

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
//        $resourceTypeClassificationRepository = $this->entityManager->getRepository(ResourceTypeClassification::class);
        $resourceTypeClassifications = $this->model->findAll();

        $results = [];
        foreach ($resourceTypeClassifications as $k => $resourceTypeClassification) {
            $results[$k]['id'] = $resourceTypeClassification->getId();
            $results[$k]['type_set'] = $resourceTypeClassification->getTypeSet();
            $results[$k]['type'] = $resourceTypeClassification->getType();
            $results[$k]['published'] = $resourceTypeClassification->getPublished();
            $results[$k]['created_at'] = $resourceTypeClassification->getCreatedAt();
            $results[$k]['updated_at'] = $resourceTypeClassification->getUpdatedAt();
            $results[$k]['actions'] = $resourceTypeClassification->getActionButtonsAttribute();
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
