<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="Building")
 */
class Building
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
     * @var HeritageResourceType
     * @todo - add multiple here & even ancilaryFeatureType
     * @OGM\Relationship(type="Assigned", direction="OUTGOING", targetEntity="HeritageResourceType", mappedBy="building")
     */
    protected $heritage_resource_type;

    /**
     * @var ArchitecturalStyle
     *
     * @OGM\Relationship(type="HasArchitecturalStyleType", direction="OUTGOING", targetEntity="ArchitecturalStyle", mappedBy="building")
     */
    protected $architectural_style;

    /**
     * @var PlotPlan
     *
     * @OGM\Relationship(type="HasProduced", direction="OUTGOING", targetEntity="PlotPlan", mappedBy="building")
     */
    protected $plot_plan;

    /**
     * @var Component
     *
     * @OGM\Relationship(type="HasProduced", direction="OUTGOING", targetEntity="Component", mappedBy="building")
     */
    protected $component;

    /**
     * @var Production
     *
     * @OGM\Relationship(type="HasProduced", direction="INCOMING", targetEntity="Production", mappedBy="production")
     */
    protected $production;

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
     * @return HeritageResourceType
     */
    public function getHeritageResourceType()
    {
        return $this->heritage_resource_type;
    }

    /**
     * @param HeritageResourceType $heritage_resource_type
     */
    public function setHeritageResourceType($heritage_resource_type)
    {
        $this->heritage_resource_type = $heritage_resource_type;
    }

    /**
     * @return ArchitecturalStyle
     */
    public function getArchitecturalStyle()
    {
        return $this->architectural_style;
    }

    /**
     * @param ArchitecturalStyle $architectural_style
     */
    public function setArchitecturalStyle($architectural_style)
    {
        $this->architectural_style = $architectural_style;
    }

    /**
     * @return PlotPlan
     */
    public function getPlotPlan()
    {
        return $this->plot_plan;
    }

    /**
     * @param PlotPlan $plot_plan
     */
    public function setPlotPlan($plot_plan)
    {
        $this->plot_plan = $plot_plan;
    }

    /**
     * @return Component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param Component $component
     */
    public function setComponent($component)
    {
        $this->component = $component;
    }

    /**
     * @return Production
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param Resource $production
     */
    public function setProduction($production)
    {
        $this->production = $production;
    }
}
