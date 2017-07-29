<?php

namespace App\Repositories\Backend\Heritage;

use App\Events\Backend\Heritage\ResourceCreated;
use App\Events\Backend\Heritage\ResourceUpdated;
use App\Models\Heritage\AdministrativeSubdivision;
use App\Models\Heritage\ArchitecturalStyle;
use App\Models\Heritage\Building;
use App\Models\Heritage\BuildingConsistsOfMaterial;
use App\Models\Heritage\Description;
use App\Models\Heritage\HeritageResourceType;
use App\Models\Heritage\Material;
use App\Models\Heritage\Modification;
use App\Models\Heritage\ModificationDescription;
use App\Models\Heritage\ModificationEvent;
use App\Models\Heritage\ModificationType;
use App\Models\Heritage\ModificationTypeOnBuilding;
use App\Models\Heritage\Name;
use App\Models\Heritage\Place;
use App\Models\Heritage\PlaceAddress;
use App\Models\Heritage\PlotPlan;
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
                \DateTime::createFromFormat('Y', $data['name_date_from'][$k]) ?: null,
                \DateTime::createFromFormat('Y', $data['name_date_to'][$k]) ?: null);

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
        foreach ($data['protection_type'] as $l => $input_property_type) {
            $protectionType = new ProtectionType($data['protection_type'][$l],
                \DateTime::createFromFormat('Y', $data['protection_type_date_from'][$l]) ?: null,
                \DateTime::createFromFormat('Y', $data['protection_type_date_to'][$l]) ?: null,
                $data['protection_type_legal'][$l] ?: null);

            if (isset($data['current_type'])) {
                if ($data['current_type'] == $l) {
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
                $updateName->setDateFrom(\DateTime::createFromFormat('Y', $data['name_date_from'][$namesArray[$f]]) ?: null);
                $updateName->setDateTo(\DateTime::createFromFormat('Y', $data['name_date_to'][$namesArray[$f]]) ?: null);
                unset($namesArray[$f]);
                $this->em->persist($updateName);
                $this->em->flush();
            } else {
                // delete
                // @TODO: see how can this be deleted
            }
        }

        if (isset($data['new_name'])) {
            foreach ($data['new_name'] as $k => $newName) {
                $name = new Name($newName,
                    \DateTime::createFromFormat('Y', $data['new_name_date_from'][$k]) ?: null,
                    \DateTime::createFromFormat('Y', $data['new_name_date_to'][$k]) ?: null);

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

        $street = $resource->getPlace()->getPlaceAddress()->getStreetName();
        if ($street->getId() != $data['street']) {
            // delete & add new one
            $newStreet = $this->em->find(StreetName::class, $data['street']);
            $resource->getPlace()->getPlaceAddress()->setStreetName($newStreet);
        }

        $number = $resource->getPlace()->getPlaceAddress();
        if ($data['number'] != $number->getNumber()) {
            $number->setNumber($data['number']);
        }

        $typesArray = array_keys($data['protection_type']);
        foreach ($resource->getProtectionTypes() as $protectionType) {
            if ($p = array_search($protectionType->getId(), $typesArray)) {
//                dd($data['protection_type'][$typesArray[$p]]);
                $updateProtection = $this->em->find(ProtectionType::class, $protectionType->getId());
                $updateProtection->setType($data['protection_type'][$typesArray[$p]]);
                $updateProtection->setDateFrom(\DateTime::createFromFormat('Y', $data['protection_type_date_from'][$typesArray[$p]]) ?: null);
                $updateProtection->setDateTo(\DateTime::createFromFormat('Y', $data['protection_type_date_to'][$typesArray[$p]]) ?: null);
                $updateProtection->setLegal($data['protection_type_legal'][$typesArray[$p]]);
                unset($typesArray[$p]);
                $this->em->persist($updateProtection);
                $this->em->flush();
            }
        }

        if (isset($data['new_protection_type'])) {
            foreach ($data['new_protection_type'] as $k => $newProtectionType) {
                $protectionType = new ProtectionType($data['new_protection_type'][$k],
                    \DateTime::createFromFormat('Y', $data['new_protection_type_date_from'][$k]) ?: null,
                    \DateTime::createFromFormat('Y', $data['new_protection_type_date_to'][$k]) ?: null,
                    $data['new_protection_type_legal'][$k] ?: null);

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

        event(new ResourceUpdated($resource));
    }

    public function createBuilding($resource_id, $input)
    {
        $data = $input['data'];
        $resource = $this->em->find(Resource::class, $resource_id);

        $production = new Production();
        if ($data['date_from'] || $data['date_to']) {
            $productionEvent = new ProductionEvent(
                $data['date_from'] ? \DateTime::createFromFormat('Y', $data['date_from']) : null,
                $data['date_to'] ?   \DateTime::createFromFormat('Y', $data['date_to']) : null);
            $production->setProductionEvent($productionEvent);
        }

        $building = new Building();
        $building->setType($data['type']);
        $building->setLevels($data['levels']);
        $building->setNotes($data['notes']);

        foreach ($data['heritage_resource_type'] as $type) {
            $heritageResourceType = $this->em->find(HeritageResourceType::class, $type);
            $building->getHeritageResourceTypes()->add($heritageResourceType);
        }
        foreach ($data['architectural_style'] as $style) {
            $architecturalStyle = $this->em->find(ArchitecturalStyle::class, $style);
            $building->getArchitecturalStyles()->add($architecturalStyle);
        }
        foreach ($data['material'] as $material) {
            $material = $this->em->find(Material::class, $material);
            $materiality = new BuildingConsistsOfMaterial($building, $material, isset($data['description']) ? $data['description'] : '');
            $building->getBuildingConsistsOfMaterials()->add($materiality);
        }

        $plot_plan = $this->em->find(PlotPlan::class, $data['plot_plan']);
        $building->setPlotPlan($plot_plan);

        if (count($data['modification_type']) > 0) {
            foreach ($data['modification_type'] as $m => $modification_type) {
                $modificationDescription = new ModificationDescription($data['modification_type_description'][$m]);
                $modificationType = $this->em->find(ModificationType::class, $modification_type);
                $modificationEvent = new ModificationEvent(
                    $modificationType,
                    $modificationDescription,
                    $data['modification_type_date_from'][$m] ? \DateTime::createFromFormat('Y', $data['modification_type_date_from'][$m]) : null,
                    $data['modification_type_date_from'][$m] ? \DateTime::createFromFormat('Y', $data['modification_type_date_to'][$m]) : null
                );
                $modification = new Modification($modificationEvent);
                $building->getModifications()->add($modification);
            }
        }

        // create all building components
//        $component = new Component();
//        foreach () {
//
//        }

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

        $production->getBuilding()->setType($data['type']);
        $production->getBuilding()->setLevels($data['levels']);
        $production->getBuilding()->setNotes($data['notes']);

        // change Heritage Resource Types
        foreach ($production->getBuilding()->getHeritageResourceTypeIds() as $existingType) {
            $t = array_search($existingType, $data['heritage_resource_type']);
            // this db has to remain
            if ($t !== false) {
                unset($data['heritage_resource_type'][$t]);
            } else {
                // this db has to be deleted
                $resourceTypes = $production->getBuilding()->getHeritageResourceTypes();
                foreach ($resourceTypes as $resourceType) {
                    if ($resourceType->getId() == $existingType) {
                        $resourceTypes->removeElement($resourceType);
                    }
                }
            }
        }
        foreach ($data['heritage_resource_type'] as $type) {
            $newType = $this->em->find(HeritageResourceType::class, $type);
            $production->getBuilding()->getHeritageResourceTypes()->add($newType);
        }

        // change Architectural Styles
        foreach ($production->getBuilding()->getArchitecturalStyleIds() as $existingStyle) {
            $s = array_search($existingStyle, $data['architectural_style']);
            // this db has to remain
            if ($s !== false) {
                unset($data['architectural_style'][$s]);
            } else {
                // this db has to be deleted
                $architecturalStyles = $production->getBuilding()->getArchitecturalStyles();
                foreach ($architecturalStyles as $architecturalStyle) {
                    if ($architecturalStyle->getId() == $existingStyle) {
                        $architecturalStyles->removeElement($architecturalStyle);
                    }
                }
            }
        }
        foreach ($data['architectural_style'] as $style) {
            $newStyle = $this->em->find(ArchitecturalStyle::class, $style);
            $production->getBuilding()->getArchitecturalStyles()->add($newStyle);
        }

        // change Materials
        foreach ($production->getBuilding()->getBuildingConsistsOfMaterialIds() as $existingMaterial) {
            $m = array_search($existingMaterial, $data['material']);
            // this db has to remain
            if ($m !== false) {
                unset($data['material'][$m]);
            } else {
                // this db has to be deleted
                $materials = $production->getBuilding()->getBuildingConsistsOfMaterials();
                foreach ($materials as $material) {
                    if ($material->getMaterial()->getId() == $existingMaterial) {
                        $materials->removeElement($material);
                        $this->em->remove($material);
                    }
                }
            }
        }
        foreach ($data['material'] as $material) {
            $newMaterial = $this->em->find(Material::class, $material);
            $materiality = new BuildingConsistsOfMaterial($production->getBuilding(), $newMaterial, isset($data['description']) ? $data['description'] : '');
            $production->getBuilding()->getBuildingConsistsOfMaterials()->add($materiality);
        }

        // change Modification Types
        foreach ($production->getBuilding()->getModifications() as $existingModification) {
            $d = array_search($existingModification->getId(), array_keys($data['modification_type']));

            if ($d !== false) {
                // modification not to be removed, lets put that aside and check if updates are needed
                $currentModificationType = $existingModification->getModificationEvent()->getModificationType();

                // type has changed, we have to update this modification instance
                if ($data['modification_type'][$existingModification->getId()] != $currentModificationType->getId()) {
                    $newModType = $this->em->find(ModificationType::class, $data['modification_type'][$existingModification->getId()]);
                    $existingModification->getModificationEvent()->setModificationType($newModType);
                }
                // update description
                $existingModification->getModificationEvent()->getModificationDescription()->setNote($data['modification_type_description'][$existingModification->getId()]);
                // update dates
                $existingModification->getModificationEvent()->setDateFrom($data['modification_type_date_from'][$existingModification->getId()] ? \DateTime::createFromFormat('Y', $data['modification_type_date_from'][$existingModification->getId()]) : null);
                $existingModification->getModificationEvent()->setDateTo($data['modification_type_date_to'][$existingModification->getId()] ? \DateTime::createFromFormat('Y', $data['modification_type_date_to'][$existingModification->getId()]) : null);

                // remove this for future reference
                unset($data['modification_type'][$existingModification->getId()]);
            } else {
                // this db has to be deleted
                // lets start with the description
                $deleteDescription = $existingModification->getModificationEvent()->getModificationDescription();
                $this->em->remove($deleteDescription, true);
                // break modification type
                $deleteType = $existingModification->getModificationEvent()->getModificationType();
                $deleteEvent = $existingModification->getModificationEvent();
                $deleteType->getModificationEvents()->removeElement($deleteEvent);
                $this->em->remove($deleteType);
                // delete modification event
                $this->em->remove($deleteEvent, true);
                // delete modification
                $this->em->remove($existingModification, true);
            }
        }
        if (isset($data['new_modification_type'])) {
            foreach ($data['new_modification_type'] as $n => $new_modification_type) {
                $newModificationDescription = new ModificationDescription($data['new_modification_type_description'][$n]);
                $newModificationType = $this->em->find(ModificationType::class, $data['new_modification_type'][$n]);
                $newModificationEvent = new ModificationEvent(
                    $newModificationType,
                    $newModificationDescription,
                    $data['new_modification_type_date_from'][$n] ? \DateTime::createFromFormat('Y', $data['new_modification_type_date_from'][$n]) : null,
                    $data['new_modification_type_date_to'][$n] ? \DateTime::createFromFormat('Y', $data['new_modification_type_date_to'][$n]) : null
                );
                $newModification = new Modification($newModificationEvent);
                $production->getBuilding()->getModifications()->add($newModification);
            }
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
