<?php

namespace App\Repositories\Backend\Heritage;

use App\Events\Backend\Heritage\ResourceCreated;
use App\Events\Backend\Heritage\ResourceUpdated;
use App\Models\Heritage\AdministrativeSubdivision;
use App\Models\Heritage\Description;
use App\Models\Heritage\Name;
use App\Models\Heritage\Place;
use App\Models\Heritage\PlaceAddress;
use App\Models\Heritage\Resource;
use App\Models\Heritage\ResourceTypeClassification;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Webpatser\Uuid\Uuid;

/**
 * Class ResourceRepository.
 */
class ResourceRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->model = $this->entityManager->getRepository(Resource::class);
    }

    /**
     * @param int $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
//        $query = $this->entityManager
//            ->createQuery("MATCH (resource:HeritageResource)-[:HasNote]->(description:Description) RETURN *");
//        $heritageResources = $query->execute();
        $resources = $this->model->findAll();

        $results = [];
        foreach ($resources as $k => $resource) {
            $results[$k]['uuid'] = explode("-", $resource->getUuid())[0];
            $results[$k]['resource_type_classification'] = $resource->getResourceTypeClassification()->getType();
            $results[$k]['name'] = $resource->getName()->getName();
            $results[$k]['created_at'] = $resource->getCreatedAt();
            $results[$k]['updated_at'] = $resource->getUpdatedAt();
            $results[$k]['actions'] = $resource->getActionButtonsAttribute();
        }

        return $results;
    }

    /**
     * @param array $input
     */
    public function create($input)
    {
        $data = $input['data'];

        $resource = new Resource();
        $resource->setUuid((string)Uuid::generate(4));
        $resource->setCreatedAt(new \DateTime());
        $resource->setUpdatedAt(new \DateTime());

        $name = new Name();
        $name->setName($data['building_name']);
        $resource->setName($name);

        $description = new Description($resource);
        $description->setUuid((string)Uuid::generate(4));
        $description->setNote($data['description']);
        $description->setCreatedAt(new \DateTime());
        $description->setUpdatedAt(new \DateTime());

        $resourceTypeClassification = $this->entityManager->find(ResourceTypeClassification::class, $data['type']);

        $resource->setDescription($description);
        $resource->setResourceTypeClassification($resourceTypeClassification);

        // initialize nodes
        $place = new Place();
        $resource->setPlace($place);

        $this->entityManager->persist($resource);
        $this->entityManager->flush();

        event(new ResourceCreated($resource));
    }

    /**
     * @param array $input
     */
    public function update($id, $input)
    {
        $data = $input['data'];

        $resource = $this->entityManager->find(Resource::class, $id);

        if ($resource->getResourceTypeClassification()->getId() != $data['type']) {
            $this->entityManager->getDatabaseDriver()
                ->run('MATCH (res:Resource)-[rel:HasResourceTypeClassification]->() WHERE id(res) = '.$id.' DELETE rel');
            $newResourceTypeClassification = $this->entityManager->find(ResourceTypeClassification::class, $data['type']);
            $resource->setResourceTypeClassification($newResourceTypeClassification);
        }

        if ($data['building_name']) {
            if ($resource->getName()) {
                if ($resource->getName()->getName() != $data['building_name']) {
                    $resource->getName()->setName($data['building_name']);
                }
            } else {
                $name = new Name();
                $name->setName($data['building_name']);
                $resource->setName($name);
            }
        }

        $resource->getDescription()->setNote($data['description']);

        $district = $this->entityManager->find(AdministrativeSubdivision::class, $data['district']);
        $resource->getPlace()->setAdministrativeSubdivision($district);
        $placeAddress = new PlaceAddress();
        $placeAddress->setStreet($data['street']);
        $placeAddress->setNumber($data['number']);
        $resource->getPlace()->setPlaceAddress($placeAddress);

        $this->entityManager->persist($resource);
        $this->entityManager->flush();

        event(new ResourceUpdated($resource));

    }
}
