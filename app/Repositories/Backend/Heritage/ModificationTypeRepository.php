<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\ModificationType;
use App\Repositories\BaseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;

/**
 * Class ModificationTypeRepository.
 */
class ModificationTypeRepository extends BaseRepository
{
    protected $em;
    protected $client;
    public $model;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(ModificationType::class);
        $this->client = $this->em->getDatabaseDriver();
    }

    /**
     * none
     */
    public function findPublished($set = null)
    {
        if ($set) {
            $queryResults = $this->em->createQuery('MATCH (n:ModificationType {published:"true", set:"'.$set.'"}) RETURN n');
            $queryResults->addEntityMapping('n', ModificationType::class);
            $result = $queryResults->getResult();
        } else {
            $criteria = new Criteria();
            $criteria->where(new Comparison('published', Comparison::EQ, "true"));
            $result = $this->model->matching($criteria);
        }

        return $result;
    }
}
