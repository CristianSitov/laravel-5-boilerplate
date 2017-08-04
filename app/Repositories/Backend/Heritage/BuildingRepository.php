<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\ArchitecturalStyle;
use App\Models\Heritage\Building;
use App\Models\Heritage\BuildingConsistsOfMaterial;
use App\Models\Heritage\Component;
use App\Models\Heritage\HeritageResourceType;
use App\Models\Heritage\Material;
use App\Models\Heritage\Modification;
use App\Models\Heritage\ModificationDescription;
use App\Models\Heritage\ModificationEvent;
use App\Models\Heritage\ModificationType;
use App\Models\Heritage\Production;
use App\Models\Heritage\ProductionEvent;
use App\Models\Heritage\Resource;
use App\Repositories\BaseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;
use Webpatser\Uuid\Uuid;

/**
 * Class BuildingRepository.
 */
class BuildingRepository extends BaseRepository
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(Building::class);
    }

    public function storeBuilding($resource_id, $input)
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
        $building->setPlan($data['plot_plan']);
        $building->setCardinality($data['order']);

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

        // initialize all types of components
        $componentTypes = Component::TYPES;
        foreach ($componentTypes as $k => $componentType) {
            $component = new Component($componentType);
            $component->setCreatedAt(new \DateTime());
            $component->setUpdatedAt(new \DateTime());
            $component->setOrder(1);
            $component->setUuid((string)Uuid::generate(4));
            $building->getComponents()->add($component);
        }

        $production->setBuilding($building);

        $resource->getProductions()->add($production);

        $this->em->persist($resource);
        $this->em->flush();
    }

    public function updateBuilding($production_id, $input)
    {
        $data = $input['data'];
        /* @var Production $production */
        $production = $this->em->find(Production::class, $production_id);

        $production->getBuilding()->setType($data['type']);
        $production->getBuilding()->setCardinality($data['order']);
        $production->getBuilding()->setLevels($data['levels']);
        $production->getBuilding()->setNotes($data['notes']);
        $production->getBuilding()->setPlan($data['plot_plan']);

        $this->em->persist($production);
        $this->em->flush();
//        $this->em->clear();

        if ($data['date_from'] || $data['date_to']) {
            $productionEvent = $production->getProductionEvent();
            if (!$productionEvent) {
                $productionEvent = new ProductionEvent();
            }
            $productionEvent->setFromDate($data['date_from'] ? \DateTime::createFromFormat('Y/m/d', $data['date_from']) : null);
            $productionEvent->setToDate($data['date_to'] ?   \DateTime::createFromFormat('Y/m/d', $data['date_to']) : null);
            $production->setProductionEvent($productionEvent);
        }

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
            if (isset($data['modification_type'])) {
                $d = array_search($existingModification->getId(), array_keys($data['modification_type']));
            } else {
                $d = false;
            }

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
                /* var ModificationType $newModificationType */
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

    public function removeBuilding($production_id) {
        $production = $this->em->find(Production::class, $production_id);

        // begin with modifications
        $modifications = $production->getBuilding()->getModifications();
        foreach ($modifications as $modification) {
            // remove description
            $deleteDescription = $modification->getModificationEvent()->getModificationDescription();
            $this->em->remove($deleteDescription, true);
            // detach type
            $deleteType = $modification->getModificationEvent()->getModificationType();
            $deleteEvent = $modification->getModificationEvent();
            $deleteType->getModificationEvents()->removeElement($deleteEvent);
            $this->em->remove($deleteType);
            // remove event
            $this->em->remove($deleteEvent, true);
            // remove modification
            $this->em->remove($modification, true);
        }

        // detach materials
        $materials = $production->getBuilding()->getBuildingConsistsOfMaterials();
        foreach ($materials as $material) {
            $materials->removeElement($material);
            $this->em->remove($material);
        }

        // detach resource types
        $resourceTypes = $production->getBuilding()->getHeritageResourceTypes();
        foreach ($resourceTypes as $resourceType) {
            $resourceTypes->removeElement($resourceType);
        }

        // detach styles
        $architecturalStyles = $production->getBuilding()->getArchitecturalStyles();
        foreach ($architecturalStyles as $architecturalStyle) {
            $architecturalStyles->removeElement($architecturalStyle);
        }

        // remove components
        $components = $production->getBuilding()->getComponents();
        foreach ($components as $component) {
            $this->em->remove($component, true);
        }

        // remove building
        $this->em->remove($production->getBuilding(), true);

        // remove production event
//        $this->em->remove($production->getProductionEvent(), true);

        // remove production
        $this->em->remove($production, true);

        $this->em->persist($production);
        $this->em->flush();
    }

    public function getByProductionid($production_id)
    {
        $production = $this->em->find(Production::class, $production_id);

        return $production->getBuilding();
    }

    public function findPublished()
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison('published', Comparison::EQ, "true"));
        return $this->model->matching($criteria);
    }
}
