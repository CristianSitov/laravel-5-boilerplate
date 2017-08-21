<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\Actor;
use App\Repositories\BaseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;

/**
 * Class MaterialRepository.
 */
class ActorRepository extends BaseRepository
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(Actor::class);
    }

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($without_trashed = true, $published_only = true)
    {
        if (!$without_trashed) {
            // admin
            $actors = $this->model->findAll();
        } else {
            if ($published_only) {
                // public
                $queryResults = $this->em->createQuery('MATCH (a:Actor) WHERE a.published IS NOT NULL AND a.deleted_at IS NULL RETURN a');
            } else {
                // desk/scout
                $queryResults = $this->em->createQuery('MATCH (a:Actor) WHERE a.deleted_at IS NULL RETURN a');
            }
            $queryResults->addEntityMapping('a', Resource::class);
            $actors = $queryResults->getResult();
        }

        $results = [];
        foreach ($actors as $k => $actor) {
            $results[$k]['id'] = $actor->getId();
            $results[$k]['created_at'] = $actor->getCreatedAt();
            $results[$k]['updated_at'] = $actor->getUpdatedAt();
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
