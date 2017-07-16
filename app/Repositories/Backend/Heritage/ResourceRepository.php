<?php

namespace App\Repositories\Backend\Heritage;

use App\Events\Backend\Heritage\ResourceCreated;
use App\Events\Backend\Heritage\ResourceUpdated;
use App\Models\Heritage\AdministrativeSubdivision;
use App\Models\Heritage\Description;
use App\Models\Heritage\HeritageResourceType;
use App\Models\Heritage\Name;
use App\Models\Heritage\PhaseTypeAssignment;
use App\Models\Heritage\Place;
use App\Models\Heritage\PlaceAddress;
use App\Models\Heritage\Production;
use App\Models\Heritage\Resource;
use App\Models\Heritage\ResourceTypeClassification;
use App\Models\Heritage\StreetName;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Webpatser\Uuid\Uuid;

/**
 * Class ResourceRepository.
 */
class ResourceRepository extends BaseRepository
{
    /**
     * @var EntityManager
     */
    public $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(Resource::class);
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
            $results[$k]['address'] = $resource->getPlace()->getPlaceAddress()->getStreetName()->getCurrentName() . ', ' .
                                      $resource->getPlace()->getPlaceAddress()->getNumber();
            $results[$k]['name'] = $resource->getCurrentName()->getName();
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

        foreach ($data['name'] as $k => $input_name) {
            $name = new Name($input_name,
                \DateTime::createFromFormat('Y/m/d', $data['date_from'][$k]) ?: null,
                \DateTime::createFromFormat('Y/m/d', $data['date_to'][$k]) ?: null);

            if (isset($data['current'][$k])) {
                $name->setCurrent(true);
            } else {
                $name->setCurrent(false);
            }

            $name->setUuid((string)Uuid::generate(4));
            $name->setCreatedAt(new \DateTime());
            $name->setUpdatedAt(new \DateTime());
            $resource->getNames()->add($name);
        }

        $description = new Description($resource);
        $description->setUuid((string)Uuid::generate(4));
        $description->setNote($data['description']);
        $description->setCreatedAt(new \DateTime());
        $description->setUpdatedAt(new \DateTime());

        $resourceTypeClassification = $this->em->find(ResourceTypeClassification::class, $data['type']);

        $resource->setDescription($description);
        $resource->setResourceTypeClassification($resourceTypeClassification);

        // initialize nodes
        // LOCATION
        $district = $this->em->find(AdministrativeSubdivision::class, $data['district']);
        $streetName = $this->em->find(StreetName::class, $data['street']);
        $place = new Place();
        $place->setAdministrativeSubdivision($district);
        $placeAddress = new PlaceAddress();
        $placeAddress->setStreetName($streetName);
        $placeAddress->setNumber($data['number']);
        $place->setPlaceAddress($placeAddress);
        $resource->setPlace($place);

        // PRODUCTION
        $production = new Production();
        $resource->getProductions()->add($production);

        $this->em->persist($resource);
        $this->em->flush();

        event(new ResourceCreated($resource));
    }

    /**
     * @param array $input
     */
    public function update($id, $input)
    {
        $data = $input['data'];

        $resource = $this->entityManager->find(Resource::class, $id);

        // GENERAL
        // type: BUILDING
        if ($resource->getResourceTypeClassification()->getId() != $data['type']) {
            $this->entityManager->getDatabaseDriver()
                ->run('MATCH (res:Resource)-[rel:HasResourceTypeClassification]->() WHERE id(res) = '.$id.' DELETE rel');
            $newResourceTypeClassification = $this->entityManager->find(ResourceTypeClassification::class, $data['type']);
            $resource->setResourceTypeClassification($newResourceTypeClassification);
        }

        // name
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

        // description
        $resource->getDescription()->setNote($data['description']);

        // STRUCTURE
        $heritageResourceType = $this->entityManager->find(HeritageResourceType::class, $data['heritage_resource_type']);
        $productions = $resource->getProductions();
        foreach ($productions as $production) {

        }

        $this->entityManager->persist($resource);
        $this->entityManager->flush();

        event(new ResourceUpdated($resource));
    }
}
