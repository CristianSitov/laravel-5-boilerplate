<?php

namespace App\Repositories\Backend\Heritage;

use App\Events\Backend\Heritage\ResourceCreated;
use App\Events\Backend\Heritage\ResourceUpdated;
use App\Models\Heritage\AdministrativeSubdivision;
use App\Models\Heritage\ArchitecturalStyle;
use App\Models\Heritage\Building;
use App\Models\Heritage\Description;
use App\Models\Heritage\HeritageResourceType;
use App\Models\Heritage\Name;
use App\Models\Heritage\Place;
use App\Models\Heritage\PlaceAddress;
use App\Models\Heritage\Production;
use App\Models\Heritage\ProductionEvent;
use App\Models\Heritage\ProtectionType;
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

            if (isset($data['current_name'])) {
                if ($data['current_name'] == $k) {
                    $name->setCurrent(true);
                } else {
                    $name->setCurrent(false);
                }
            } else {
                $name->setCurrent(true);
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
        foreach ($data['protection_type'] as $k => $input_property_type) {
            $protectionType = new ProtectionType($input_property_type,
                \DateTime::createFromFormat('m/d/Y', $data['protection_type_date_from'][$k]) ?: null,
                \DateTime::createFromFormat('m/d/Y', $data['protection_type_date_to'][$k]) ?: null);

            if (isset($data['current_type'])) {
                if ($data['current_type'] == $k) {
                    $protectionType->setCurrent(true);
                } else {
                    $protectionType->setCurrent(false);
                }
            } else {
                $protectionType->setCurrent(true);
            }

            $protectionType->setUuid((string)Uuid::generate(4));
            $protectionType->setCreatedAt(new \DateTime());
            $protectionType->setUpdatedAt(new \DateTime());
            $resource->getProtectionTypes()->add($protectionType);
        }

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

        $namesArray = array_keys($data['name']);
        foreach ($resource->getNames() as $name) {
            if ($f = array_search($name->getId(), $namesArray)) {
                // update this if matches ID
                $updateName = $this->em->find(Name::class, $name->getId());
                $updateName->setName($data['name'][$namesArray[$f]]);
                $updateName->setDateFrom($data['date_from'][$namesArray[$f]]);
                $updateName->setDateFrom($data['date_to'][$namesArray[$f]]);
                unset($namesArray[$f]);
            }
        }

        if (isset($data['new_name'])) {
            foreach ($data['new_name'] as $k => $newName) {
                $name = new Name($newName,
                    \DateTime::createFromFormat('Y/m/d', $data['new_date_from'][$k]) ?: null,
                    \DateTime::createFromFormat('Y/m/d', $data['new_date_to'][$k]) ?: null);

                if (isset($data['current_name'])) {
                    if ($data['current_name'] == ($k + count($data['name']))) {
                        $name->setCurrent(true);
                    } else {
                        $name->setCurrent(false);
                    }
                } else {
                    $name->setCurrent(true);
                }

                $name->setUuid((string)Uuid::generate(4));
                $name->setCreatedAt(new \DateTime());
                $name->setUpdatedAt(new \DateTime());
                $resource->getNames()->add($name);
            }
        }

        $resource->getDescription()->setNote($data['description']);

        $typesArray = array_keys($data['protection_type']);
        foreach ($resource->getProtectionTypes() as $protectionType) {
            if ($p = array_search($protectionType->getId(), $typesArray)) {

                $updateProtection = $this->em->find(ProtectionType::class, $protectionType->getId());
                $updateProtection->setProtectionType($data['protection_type'][$typesArray[$p]]);
                $updateProtection->setDateFrom($data['protection_type_date_from'][$typesArray[$p]]);
                $updateProtection->setDateFrom($data['protection_type_date_to'][$typesArray[$p]]);
                unset($typesArray[$p]);
            }
        }

        if (isset($data['new_protection_type'])) {
            foreach ($data['new_protection_type'] as $k => $newProtectionType) {
                $protectionType = new ProtectionType($newProtectionType,
                    \DateTime::createFromFormat('Y/m/d', $data['new_protection_type_date_from'][$k]) ?: null,
                    \DateTime::createFromFormat('Y/m/d', $data['new_protection_type_date_to'][$k]) ?: null);

                if (isset($data['current_type'])) {
                    if ($data['current_type'] == ($k + count($data['protection_type']))) {
                        $protectionType->setCurrent(true);
                    } else {
                        $protectionType->setCurrent(false);
                    }
                } else {
                    $protectionType->setCurrent(true);
                }

                $protectionType->setUuid((string)Uuid::generate(4));
                $protectionType->setCreatedAt(new \DateTime());
                $protectionType->setUpdatedAt(new \DateTime());
                $resource->getProtectionTypes()->add($protectionType);
            }
        }

        $this->em->persist($resource);
        $this->em->flush();
//        dd($data, $resource);

        event(new ResourceUpdated($resource));
    }

    public function createBuilding($resource_id, $input)
    {
        $data = $input['data'];
        $resource = $this->em->find(Resource::class, $resource_id);

        $production = new Production();
        if ($data['date_from'] || $data['date_to']) {
            $productionEvent = new ProductionEvent(
                $data['date_from'] ? \DateTime::createFromFormat('Y/m/d', $data['date_from']) : null,
                $data['date_to'] ?   \DateTime::createFromFormat('Y/m/d', $data['date_to']) : null);
            $production->setProductionEvent($productionEvent);
        }

        $building = new Building();
        $building->setType($data['type']);

        foreach ($data['heritage_resource_type'] as $type) {
            $heritageResourceType = $this->em->find(HeritageResourceType::class, $type);
            $building->getHeritageResourceTypes()->add($heritageResourceType);
        }
        foreach ($data['architectural_style'] as $style) {
            $architecturalStyle = $this->em->find(ArchitecturalStyle::class, $style);
            $building->getArchitecturalStyles()->add($architecturalStyle);
        }

        $production->setBuilding($building);

        $resource->getProductions()->add($production);

        $this->em->persist($resource);
        $this->em->flush();
    }

    public function updateBuilding($building_id, $input)
    {
        $data = $input['data'];
        $production = $this->em->find(Production::class, $building_id);

        if ($data['date_from'] || $data['date_to']) {
            $productionEvent = $production->getProductionEvent();
            if (!$productionEvent) {
                $productionEvent = new ProductionEvent();
            }
            $productionEvent->setFromDate($data['date_from'] ? \DateTime::createFromFormat('Y/m/d', $data['date_from']) : null);
            $productionEvent->setToDate($data['date_to'] ?   \DateTime::createFromFormat('Y/m/d', $data['date_to']) : null);
            $production->setProductionEvent($productionEvent);
        }

        $this->em->persist($production);
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
