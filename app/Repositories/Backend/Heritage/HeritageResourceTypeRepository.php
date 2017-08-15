<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\HeritageResourceType;
use App\Repositories\BaseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;

/**
 * Class ResourceRepository.
 */
class HeritageResourceTypeRepository extends BaseRepository
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(HeritageResourceType::class);
    }

    public function findPublished()
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison('published', Comparison::EQ, "true"));
        return $this->model->matching($criteria);
    }

    public function createClone(array $data)
    {
        $clone = new HeritageResourceType();

        foreach ($data as $prop => $value) {
            $clone->{'set'.ucfirst(camel_case($prop))}($value);
        }

        return $clone;
    }

    public function findAllStencils()
    {
        $queryResults = $this->em->createQuery('MATCH (type:HeritageResourceType) OPTIONAL MATCH (b:Building)-[r:Assigned]->(type) WITH type,r WHERE r IS NULL AND type.published="true" RETURN type');
        $queryResults->addEntityMapping('type', HeritageResourceType::class);
        $result = $queryResults->getResult();

        return $result;
    }

    public function findStencilsByUuid($uuid)
    {
        $queryResults = $this->em->createQuery('MATCH (type:HeritageResourceType {uuid:"'.$uuid.'"}) OPTIONAL MATCH (b:Building)-[r:Assigned]->(type) WITH type,r WHERE r IS NULL AND type.published="true" RETURN type');
        // use "n" to full OGM and access properties through values() method
        $queryResults->addEntityMapping('n', HeritageResourceType::class);
        $result = $queryResults->getResult();

        return $result;
    }
}
