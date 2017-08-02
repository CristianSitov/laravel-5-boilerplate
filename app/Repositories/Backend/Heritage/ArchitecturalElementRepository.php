<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\ArchitecturalElement;
use App\Models\Heritage\Component;
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

                        // check if current Component does have such element
                        if (in_array($stencilElement[0]['element']->values()['uuid'], array_keys($existingElementsArray))) {
                            // update the thing
                            // set modifications here, since it is the only thing that changes
                            // remove element from array
                            $unsetElementUuid = $stencilElement[0]['element']->values()['uuid'];
                            unset($existingElementsArray[$unsetElementUuid]);
                        } else {
                            // create the thing
                            $newElement = new ArchitecturalElement($stencilElement[0]['element']->values());
                            $component->getArchitecturalElements()->add($newElement);
                            unset($existingElementsArray[$newElement->getUuid()]);
                        }
                    }
                }
            } elseif (in_array('single', $architectural_element_map[$set])) {

            }
        }

        // now, consider deleting all the elements that weren't found
        if (count($existingElementsArray) > 0) {
            foreach ($existingElementsArray as $uuid => $existingElement) {
                $removeElement = $component->getArchitecturalElementByUuid($uuid);
                $this->em->remove($removeElement, true);
            }
        }

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
