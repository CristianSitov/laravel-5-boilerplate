<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\Actor;
use App\Models\Heritage\Resource;
use App\Repositories\BaseRepository;
use App\Models\Heritage\IsRelatedTo;
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

    public function store($data, $resource)
    {
        $actor = new Actor();
        $actor->setAppelation($data['appelation']);
        $actor->setFirstName($data['first_name']);
        $actor->setLastName($data['last_name']);
        $actor->setNickName($data['nick_name']);
        $actor->setIsLegal($data['is_legal']);
        $actor->setKeywords($data['keywords']);
        $actor->setDescription($data['description']);
        $actor->setDateBirth($data['date_birth']);
        $actor->setDateDeath($data['date_death']);
        $actor->setPlaceBirth($data['place_birth']);
        $actor->setPlaceDeath($data['place_death']);
        $actor->setCreatedAt(new \DateTime());
        $actor->setUpdatedAt(new \DateTime());

        $this->em->persist($actor);
        $this->em->flush();

        $resource->getIsRelatedTo()->add(new IsRelatedTo($actor, $resource, $data['relationship'], $data['date_from'], $data['date_to']));

        $this->em->persist($actor);
        $this->em->persist($resource);
        $this->em->flush();

        return $actor;
    }

    /**
     * @param $data
     * @param Resource $resource
     * @param Actor $actor
     *
     * @return mixed
     */
    public function update($data, $resource, $actor)
    {
        $actor->setAppelation($data['appelation']);
        $actor->setFirstName($data['first_name']);
        $actor->setLastName($data['last_name']);
        $actor->setNickName($data['nick_name']);
        $actor->setIsLegal($data['is_legal']);
        $actor->setKeywords($data['keywords']);
        $actor->setDescription($data['description']);
        $actor->setDateBirth($data['date_birth']);
        $actor->setDateDeath($data['date_death']);
        $actor->setPlaceBirth($data['place_birth']);
        $actor->setPlaceDeath($data['place_death']);
        $actor->setUpdatedAt(new \DateTime());

        $this->em->persist($actor);
        $this->em->flush();

        // detect changes
        $resource->getIsRelatedTo()->add(new IsRelatedTo($actor, $resource, $data['relationship'], $data['date_from'], $data['date_to']));

        $this->em->persist($actor);
        $this->em->persist($resource);
        $this->em->flush();
    }

    public function getForDataTable($resource, $without_trashed = true, $published_only = true)
    {
        if (!$without_trashed) {
            // admin
            $queryResults = $this->em->createQuery('MATCH (actor:Actor)-[rel:IsRelatedTo]-(resource:Resource) WHERE ID(resource)='.$resource.' RETURN actor, rel, resource');
        } else {
            if ($published_only) {
                // public
                $queryResults = $this->em->createQuery('MATCH (actor:Actor)-[rel:IsRelatedTo]-(resource:Resource) WHERE ID(resource)='.$resource.' AND WHERE actor.published IS NOT NULL AND actor.deleted_at IS NULL RETURN actor, rel, resource');
            } else {
                // desk/scout
                $queryResults = $this->em->createQuery('MATCH (actor:Actor)-[rel:IsRelatedTo]-(resource:Resource) WHERE ID(resource)='.$resource.' AND WHERE actor.deleted_at IS NULL RETURN actor, rel, resource');
            }
        }
        $queryResults->addEntityMapping('actor', Actor::class);
        $queryResults->addEntityMapping('resource', Resource::class);
        $rawResults = $queryResults->getResult();

        $results = [];
        foreach ($rawResults as $k => $rawResult) {
            $relations = [];
            foreach($rawResult['actor']->getIsRelatedTo() as $isRelatedTo) {
                $relations[] = trans('strings.backend.actor.' . $isRelatedTo->getRelation());
            }
            $results[$k]['id'] = $rawResult['actor']->getId();
            $results[$k]['relation'] = implode(', ', $relations);
            $results[$k]['name'] = $rawResult['actor']->getAppelation() . ' ' . $rawResult['actor']->getFirstName() . ' ' . $rawResult['actor']->getLastName();
            $results[$k]['address'] = $rawResult['resource']->getPlace()->getPlaceAddress()->getStreetName()->getCurrentName().', nr. '.$rawResult['resource']->getPlace()->getPlaceAddress()->getNumber();
            $results[$k]['actions'] = $rawResult['actor']->getActionButtonsAttribute($rawResult['resource']);
            $results[$k]['created_at'] = $rawResult['actor']->getCreatedAt() ? $rawResult['actor']->getCreatedAt()->format('Y-m-d H:i:s') : '';
            $results[$k]['updated_at'] = $rawResult['actor']->getUpdatedAt() ? $rawResult['actor']->getUpdatedAt()->format('Y-m-d H:i:s') : '';
        }

        return $results;
    }

    public function findPublished()
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison('published', Comparison::EQ, 'true'));
        return $this->model->matching($criteria);
    }
}
