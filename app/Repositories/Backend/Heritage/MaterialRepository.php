<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\Material;
use App\Repositories\BaseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;

/**
 * Class MaterialRepository.
 */
class MaterialRepository extends BaseRepository
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(Material::class);
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
     * none
     */
    public function findPublished()
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison('published', Comparison::EQ, "true"));
        return $this->model->matching($criteria);
    }
}
