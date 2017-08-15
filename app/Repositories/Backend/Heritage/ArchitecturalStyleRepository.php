<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\ArchitecturalStyle;
use App\Repositories\BaseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;

/**
 * Class ArchitecturalStyleRepository.
 */
class ArchitecturalStyleRepository extends BaseRepository
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(ArchitecturalStyle::class);
    }

    public function findPublished()
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison('published', Comparison::EQ, "true"));
        return $this->model->matching($criteria);
    }

    public function createClone(array $data)
    {
        $clone = new ArchitecturalStyle();

        foreach ($data as $prop => $value) {
            $clone->{'set'.ucfirst(camel_case($prop))}($value);
        }

        return $clone;
    }

    public function findAllStencils()
    {
        $queryResults = $this->em->createQuery('MATCH (style:ArchitecturalStyle) OPTIONAL MATCH (b:Building)-[r:HasArchitecturalStyleType]->(style) WITH style,r WHERE r IS NULL AND style.published="true" RETURN style');
        $queryResults->addEntityMapping('style', ArchitecturalStyle::class);
        $result = $queryResults->getResult();

        return $result;
    }

    public function findStencilsByUuid($uuid)
    {
        $queryResults = $this->em->createQuery('MATCH (style:ArchitecturalStyle {uuid:"'.$uuid.'"}) OPTIONAL MATCH (b:Building)-[r:HasArchitecturalStyleType]->(style) WITH style,r WHERE r IS NULL AND style.published="true" RETURN style');
        // use "n" to full OGM and access properties through values() method
        $queryResults->addEntityMapping('n', ArchitecturalStyle::class);
        $result = $queryResults->getResult();

        return $result;
    }

}
