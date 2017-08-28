<?php

namespace App\Repositories\Frontend\Heritage;

use App\Models\Heritage\Actor;
use App\Models\Heritage\AdministrativeSubdivision;
use App\Models\Heritage\IsRelatedTo;
use App\Models\Heritage\Name;
use App\Models\Heritage\Place;
use App\Models\Heritage\PlaceAddress;
use App\Models\Heritage\Resource;
use App\Models\Heritage\StreetName;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use GraphAware\Neo4j\OGM\Query;

/**
 * Class ResourceRepository.
 */
class HeritageRepository extends BaseRepository
{
    public $em;
    public $model;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(Resource::class);
    }

    public function getForPublic()
    {
        $queryResults = $this->em->createQuery('MATCH (district:AdministrativeSubdivision)-[ds]-(street:StreetName)
            MATCH (street:StreetName)-[spa]-(number:PlaceAddress)
            MATCH (number:PlaceAddress)-[np]-(p:Place)
            MATCH (p:Place)-[pr]-(resource:Resource)
            MATCH (resource:Resource)-[rn]-(name:Name)
            WHERE resource.deleted_at IS NULL
            RETURN district, street, number, resource, COLLECT(name) AS names');
        // AND r.published IS NOT NULL

        $queryResults->addEntityMapping('district', AdministrativeSubdivision::class);
        $queryResults->addEntityMapping('street', StreetName::class);
        $queryResults->addEntityMapping('number', PlaceAddress::class);
        $queryResults->addEntityMapping('resource', Resource::class);
        $queryResults->addEntityMapping('names', Name::class, Query::HYDRATE_COLLECTION);
        $resources = $queryResults->getResult();

        $results = [];
        /* @var \App\Models\Heritage\Resource $resource */
        foreach ($resources as $k => $resource) {
            $names = [];
            if (count($resource['names']) > 0) {
                foreach ($resource['names'] as $name) {
                    $names[] = [
                        'name' => $name->getName(),
                        'current' => $name->getCurrent(),
                    ];
                }
            }
            $actors = [];
            if (count($resource['resource']->getIsRelatedTo()) > 0) {
                /* @var IsRelatedTo $relation */
                foreach ($resource['resource']->getIsRelatedTo() as $relation) {
                    $actor = $relation->getActor();
                    $actors[] = [
                        'relation' => $relation->getRelation(),
                        'relation_since' => $relation->getSince(),
                        'relation_until' => $relation->getUntil(),
                        'appelation' => $actor->getAppelation(),
                        'first_name' => $actor->getFirstName(),
                        'last_name' => $actor->getLastName(),
                        'nick_name' => $actor->getNickName(),
                        'is_legal' => $actor->getIsLegal(),
                    ];
                }
            }
            $results[] = [
                'district' => $resource['district']->getName(),
                'street' => $resource['street']->getCurrentName(),
                'number' => $resource['number']->getNumber(),
                'names' => $names,
                'actors' => $actors,
            ];
        }

        return $results;
    }
}
