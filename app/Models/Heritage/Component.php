<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="Component")
 */
class Component
{
    use Uuids;

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
     * @var ComponentType
     *
     * @OGM\Relationship(type="HasComponentType", direction="OUTGOING", targetEntity="ComponentType", mappedBy="component")
     */
    protected $component_type;

    /**
     * @var ComponentField
     *
     * @OGM\Relationship(type="ConsistsOf", direction="OUTGOING", targetEntity="ComponentField", mappedBy="component")
     */
    protected $component_field;

    /**
     * @var Material
     *
     * @OGM\Relationship(type="ConsistsOf", direction="OUTGOING", targetEntity="Material", mappedBy="component")
     */
    protected $material;

    /**
     * @var ArchitecturalElement
     *
     * @OGM\Relationship(type="HasProduced", direction="OUTGOING", targetEntity="ArchitecturalElement", mappedBy="component")
     */
    protected $architectural_element;

    /**
     * @var ConditionAssessment
     *
     * @OGM\Relationship(type="Concerned", direction="OUTGOING", targetEntity="ConditionAssessment", mappedBy="component")
     */
    protected $condition_assessment;

    /**
     * @var Building
     *
     * @OGM\Relationship(type="HasProduced", direction="INCOMING", targetEntity="Building", mappedBy="component")
     */
    protected $building;

    public function __construct(Resource $resource = null)
    {
        $this->resource = $resource;
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
     * @return ComponentType
     */
    public function getComponentType()
    {
        return $this->component_type;
    }

    /**
     * @param ComponentType $component_type
     */
    public function setComponentType($component_type)
    {
        $this->component_type = $component_type;
    }

    /**
     * @return string
     */
    public function getComponentField()
    {
        return $this->component_field;
    }

    /**
     * @param string $component_field
     */
    public function setComponentField($component_field)
    {
        $this->component_field = $component_field;
    }

    /**
     * @return Material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param Material $material
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * @return ArchitecturalElement
     */
    public function getArchitecturalElement()
    {
        return $this->architectural_element;
    }

    /**
     * @param ArchitecturalElement $architectural_element
     */
    public function setArchitecturalElement($architectural_element)
    {
        $this->architectural_element = $architectural_element;
    }

    /**
     * @return ConditionAssessment
     */
    public function getConditionAssessment()
    {
        return $this->condition_assessment;
    }

    /**
     * @param ConditionAssessment $condition_assessment
     */
    public function setConditionAssessment($condition_assessment)
    {
        $this->condition_assessment = $condition_assessment;
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
