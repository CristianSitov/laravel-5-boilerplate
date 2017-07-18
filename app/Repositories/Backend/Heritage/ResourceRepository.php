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
    const STATUSES = [
        'field_ready' => [
            'label' => 'default',
            'name' => 'I. Desk - Imported'
        ],
        'field_done' => [
            'label' => 'danger',
            'name' => 'II. Field - Mapped',
        ],
        'moderated' => [
            'label' => 'warning',
            'name' => 'III. Desk - Evaluated',
        ],
        'published' => [
            'label' => 'info',
            'name' => 'IV. Published',
        ],
    ];

    const PROGRESSES = [
        '15' => [
            'label' => 'default',
            'value' => '15'
        ],
        '30' => [
            'label' => 'danger',
            'value' => '30',
        ],
        '60' => [
            'label' => 'warning',
            'value' => '60',
        ],
        '80' => [
            'label' => 'info',
            'value' => '80',
        ],
        '100' => [
            'label' => 'success',
            'value' => '100',
        ],
    ];

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
            $results[$k]['status'] = $resource->getStatus();
            $results[$k]['progress'] = $resource->getProgress();
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
        $resource->setProgress(15);
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

        // LEGALS (judicial, proprietary)
        // @TODO

        $this->em->persist($resource);
        $this->em->flush();

        event(new ResourceCreated($resource));
    }

    /**
     * @param int $id
     * @param array $input
     */
    public function update($id, $input)
    {
        $data = $input['data'];

        $resource = $this->em->find(Resource::class, $id);

        // STRUCTURE
        $heritageResourceType = $this->em->find(HeritageResourceType::class, $data['type_ro']);
        dd($heritageResourceType);
        $productions = $resource->getProductions();
        foreach ($productions as $production) {

        }

        $this->em->persist($resource);
        $this->em->flush();

        event(new ResourceUpdated($resource));
    }

    public function updateBuilding($id, $data)
    {
        $resource = $this->em->find(Resource::class, $id);

        $production = new Production();
        $resource->getProductions()->add($production);

        $this->em->persist($resource);
        $this->em->flush();
    }

    /**
     * @param int $id
     */
    public function softDelete($id)
    {
        $resource = $this->em->find(Resource::class, $id);
        $resource->setDeletedAt(new \DateTime());
        $this->em->persist($resource);
        $this->em->flush();
    }

    /**
     * @param int $id
     */
    public function restoreDelete($id)
    {
        $resource = $this->em->find(Resource::class, $id);
        $resource->setDeletedAt(null);
        $this->em->persist($resource);
        $this->em->flush();
    }
}
