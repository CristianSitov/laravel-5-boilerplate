<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\Building;
use App\Repositories\BaseRepository;
use App\Models\Heritage\Component;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;
use Webpatser\Uuid\Uuid;

/**
 * Class ComponentRepository.
 */
class ComponentRepository extends BaseRepository
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(Component::class);
    }

    public function create(Building $building)
    {
        // only FACADE
        $component = new Component('facade');
        $component->setCreatedAt(new \DateTime());
        $component->setUpdatedAt(new \DateTime());
        $component->setOrder(count($building->getComponentsByType('facade')) + 1);
        $component->setUuid((string)Uuid::generate(4));

        $building->getComponents()->add($component);

        $this->em->persist($building);
        $this->em->flush();

    }

    public function findPublished()
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison('published', Comparison::EQ, "true"));
        return $this->model->matching($criteria);
    }
}
