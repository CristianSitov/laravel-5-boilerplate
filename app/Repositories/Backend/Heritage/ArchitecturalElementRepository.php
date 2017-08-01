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
        dd($data);
        $component_type = $component->getType();
        $architectural_element_map = ArchitecturalElement::MAP[$component_type];

        $elements = array_keys($architectural_element_map);

        foreach ($elements as $element) {
            if (in_array('multiple', $architectural_element_map[$element])) {
                // multiple values, iterate
                foreach ($data[$element] as $value) {
                    // find in Neo
                    $findElement = $this->model->findBy(['uuid' => $value]);
                    dd($findElement);
                    // check if current Component does have such element
                    if ($component->getArchitecturalElementByUuid($findElement->getUuid()) != null) {

                    } else {
                        // create the thing
                        $newElement = new ArchitecturalElement($findElement->toArray());
                        $component->getArchitecturalElements()->add($newElement);
                    }
                }
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
}
