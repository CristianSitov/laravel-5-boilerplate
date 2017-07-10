<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\ResourceClassificationType;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResourceRepository.
 */
class ResourceClassificationTypeRepository extends BaseRepository
{
    /**
     * import process script
     * LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E55.ResourceClassificationType_endline_unix.csv" AS row
     * CREATE (n:ResourceClassificationType)
     * SET n = row,
     * n.typeSet = row.typeSet,
     * n.type = row.type,
     * n.published = toBoolean(row.published)
     */
    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        $resourceClassificationTypeRepository = $this->entityManager->getRepository(ResourceClassificationType::class);
        $classificationTypes = $resourceClassificationTypeRepository->findAll();

        $results = [];
        foreach ($classificationTypes as $k => $classificationType) {
            $results[$k]['id'] = $classificationType->getId();
            $results[$k]['type_set'] = $classificationType->getTypeSet();
            $results[$k]['type'] = $classificationType->getType();
            $results[$k]['published'] = $classificationType->getPublished();
            $results[$k]['created_at'] = $classificationType->getCreatedAt();
            $results[$k]['updated_at'] = $classificationType->getUpdatedAt();
            $results[$k]['actions'] = $classificationType->getActionButtonsAttribute();
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
