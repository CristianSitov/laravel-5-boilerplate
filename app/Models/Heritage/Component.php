<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="Component")
 */
class Component
{
    use Uuids;

    const TYPES = [
        'roof',
        'facade',
        'access',
    ];

    /**
     * @var int
     *
     * @OGM\GraphId()
     */
    protected $id;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $uuid;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $updated_at;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $published_at;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $type;

    /**
     * @var int
     *
     * @OGM\Property(type="int")
     */
    protected $order;

    /**
     * @var ArchitecturalElement[]|Collection
     *
     * @OGM\Relationship(type="HasProduced", direction="OUTGOING", targetEntity="ArchitecturalElement", collection=true, mappedBy="component")
     * @OGM\OrderBy(property="order", order="ASC")
     */
    protected $architecturalElements;

    /**
     * @var ConditionAssessment
     *
     * @OGM\Relationship(type="Concerned", direction="OUTGOING", targetEntity="ConditionAssessment", mappedBy="component")
     */
    protected $conditionAssessment;

    /**
     * @var Building
     *
     * @OGM\Relationship(type="IsComposedOf", direction="INCOMING", targetEntity="Building", mappedBy="component")
     */
    protected $building;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->published_at;
    }
    /**
     * @param \DateTime $published_at
     */
    public function setPublishedAt($published_at)
    {
        $this->published_at = $published_at;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return ConditionAssessment
     */
    public function getConditionAssessment()
    {
        return $this->conditionAssessment;
    }

    /**
     * @param ConditionAssessment $condition_assessment
     */
    public function setConditionAssessment($condition_assessment)
    {
        $this->conditionAssessment = $condition_assessment;
    }

    /**
     * @return ArchitecturalElement[]|Collection
     */
    public function getArchitecturalElements()
    {
        return $this->architecturalElements;
    }

    /**
     * @return ArchitecturalElement[]|null
     */
    public function getArchitecturalElementsByType($type)
    {
        $architecturalElements = [];
        foreach ($this->getArchitecturalElements() as $architecturalElement) {
            if ($architecturalElement->getType() === $type) {
                $architecturalElements[] = $architecturalElement;
            }
        }

        return $architecturalElements;
    }

    /**
     * @return ArchitecturalElement[]|null
     */
    public function getArchitecturalElementBySet($set)
    {
        foreach ($this->getArchitecturalElements() as $architecturalElement) {
            if ($architecturalElement->getSet() === $set) {
                return $architecturalElement;
            }
        }

        return null;
    }

    /**
     * @return ArchitecturalElement[]|null
     */
    public function getArchitecturalElementByUuid($uuid)
    {
        foreach ($this->getArchitecturalElements() as $architecturalElement) {
            if ($architecturalElement->getUuid() === $uuid) {
                return $architecturalElement;
            }
        }

        return null;
    }

    /**
     * @return Building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param Building $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    }
}
