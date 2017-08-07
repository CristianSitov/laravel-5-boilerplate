<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\ArchitecturalElement;
use App\Models\Heritage\Component;
use App\Models\Heritage\Modification;
use App\Models\Heritage\ModificationDescription;
use App\Models\Heritage\ModificationEvent;
use App\Models\Heritage\ModificationType;
use App\Repositories\BaseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use GraphAware\Neo4j\OGM\EntityManager;
use Webpatser\Uuid\Uuid;

/**
 * Class ArchitecturalElementRepository.
 */
class ArchitecturalElementRepository extends BaseRepository
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(ArchitecturalElement::class);
    }

    public function updateElement(Component $component, $data) {
        $component_type = $component->getType();
        $architectural_element_map = ArchitecturalElement::MAP[$component_type];
        $sets = array_keys($architectural_element_map);

        $existingElements = $component->getArchitecturalElementsByType($component_type);
        $existingElementsArray = [];
        if (count($existingElements) > 0) {
            foreach ($existingElements as $existingElement) {
                $existingElementsArray[$existingElement->getUuid()] = $existingElement;
            }
        }

        // iterate through all possible elements
        foreach ($sets as $set) {
            if (in_array('multiple', $architectural_element_map[$set])) {
                // multiple values, iterate
                if (isset($data[$set])) {
                    foreach ($data[$set] as $uuid) {
                        // find in Neo
                        $stencilElement = $this->findStencilsByUuid($uuid);

                        $modified = '';
                        if (isset($data[$set.'_modified'][$uuid])) {
                            $modified = $data[$set.'_modified'][$uuid];
                        }

                        // check if current Component does have such element
                        if (in_array($stencilElement[0]['element']->values()['uuid'], array_keys($existingElementsArray))) {
                            // set modifications here, since it is the only thing that changes
                            if ($modified != '') {
                                // update the thing
                                $updateElement = $component->getArchitecturalElementByUuid($stencilElement[0]['element']->values()['uuid']);
                                $updateElement->setModified($modified);
                            }
                            // remove element from array
                            $unsetElementUuid = $stencilElement[0]['element']->values()['uuid'];
                            unset($existingElementsArray[$unsetElementUuid]);
                        } else {
                            // create the thing
                            $newElement = new ArchitecturalElement($stencilElement[0]['element']->values());
                            if ($modified != '') {
                                $newElement->setModified($modified);
                            }
                            $component->getArchitecturalElements()->add($newElement);
                            unset($existingElementsArray[$newElement->getUuid()]);
                        }
                    }
                }
            } elseif (in_array('single', $architectural_element_map[$set])) {
                if (isset($data[$set])) {
                    $stencilElement = $this->findStencilsByUuid($data[$set]);
                    $existingElement = $component->getArchitecturalElementBySet($set);
                    if (count($existingElement) > 0) {
                        // delete
                        $this->em->remove($existingElement, true);
                    }
                    // create it
                    $newElement = new ArchitecturalElement($stencilElement[0]['element']->values());
                    $component->getArchitecturalElements()->add($newElement);
                    // unset
                    unset($existingElementsArray[$newElement->getUuid()]);
                }
            }
        }

        // modifications, very similar code with BuildingRepository
        // @TODO; optimize this?!?!
        foreach ($component->getModifications() as $existingModification) {
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
                $existingModification->getModificationEvent()->getModificationDescription()->setNote($data['modification_type_modified'][$existingModification->getId()]);
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
                // delete modification event
                $this->em->remove($deleteEvent, true);
                // delete modification
                $this->em->remove($existingModification, true);
            }
        }
        if (isset($data['modification_type']) && count($data['modification_type']) > 0) {
            foreach ($data['modification_type'] as $n => $new_modification_type) {
                $newModificationDescription = new ModificationDescription($data['modification_type_description'][$new_modification_type]);
                /* var ModificationType $newModificationType */
                $newModificationType = $this->em->find(ModificationType::class, $data['modification_type'][$n]);
                $newModificationEvent = new ModificationEvent(
                    $newModificationType,
                    $newModificationDescription,
                    // no dates yet
                    null,
                    null
//                    $data['modification_type_date_from'][$new_modification_type] ? \DateTime::createFromFormat('Y', $data['modification_type_date_from'][$new_modification_type]) : null,
//                    $data['modification_type_date_to'][$new_modification_type] ? \DateTime::createFromFormat('Y', $data['modification_type_date_to'][$new_modification_type]) : null
                );
                $newModification = new Modification($newModificationEvent);
                $component->getModifications()->add($newModification);
            }
        }

        // now, consider deleting all the elements that weren't found
        if (count($existingElementsArray) > 0) {
            foreach ($existingElementsArray as $uuid => $existingElement) {
                $removeElement = $component->getArchitecturalElementByUuid($uuid);
                $this->em->remove($removeElement, true);
            }
        }

        $component->setNote($data['notes']);

        $this->em->persist($component);
        $this->em->flush();
    }

    public function findPublished($type = null)
    {
        if ($type) {
            $queryResults = $this->em->createQuery('MATCH (n:ArchitecturalElement {published:"true", type:"'.$type.'"}) RETURN n');
            $queryResults->addEntityMapping('n', ArchitecturalElement::class);
            $result = $queryResults->getResult();
        } else {
            $criteria = new Criteria();
            $criteria->where(new Comparison('published', Comparison::EQ, "true"));
            $result = $this->model->matching($criteria);
        }

        return $result;
    }

    public function findStencilsByUuid($uuid)
    {
        $queryResults = $this->em->createQuery('MATCH (element:ArchitecturalElement {uuid:"'.$uuid.'"}) OPTIONAL MATCH (c:Component)-[r:HasProduced]->(element) WITH element,r WHERE r IS NULL RETURN element');
        $queryResults->addEntityMapping('n', ArchitecturalElement::class);
        $result = $queryResults->getResult();

        return $result;
    }

    public function removeByUuid(Component $component, $uuid) {
        $removeElement = $component->getArchitecturalElementByUuid($uuid);

        if ($removeElement) {
            $component->getArchitecturalElements()->removeElement($removeElement);
            $this->em->remove($removeElement, true);
        }

        $this->em->persist($component);
        $this->em->flush();
    }
}
