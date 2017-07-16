<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\HeritageResourceType;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResourceRepository.
 */
class HeritageResourceTypeRepository extends BaseRepository
{
    /**
     * import process script
     * LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E55.HeritageResourceType_01.csv" AS row CREATE (n:HeritageResourceType)
     * SET n = row,
     * n.uuid = row.uuid,
     * n.type = row.type,
     * n.type_ro = row.type_ro,
     * n.type_set = row.type_set,
     * n.type_set_ro = row.type_set_ro,
     * n.published_at = row.published,
     * n.created_at = timestamp(),
     * n.updated_at = timestamp();
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->model = $this->entityManager->getRepository(HeritageResourceType::class);
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
