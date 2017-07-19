<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

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
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $type;

    /**
     * @var HeritageResourceType
     * @todo - add multiple here & even ancilaryFeatureType
     * @OGM\Relationship(type="Assigned", direction="OUTGOING", collection=true, targetEntity="HeritageResourceType", mappedBy="building")
     */
    protected $heritageResourceTypes;

    /**
     * @var ArchitecturalStyle[]|Collection
     *
     * @OGM\Relationship(type="HasArchitecturalStyleType", direction="OUTGOING", collection=true, targetEntity="ArchitecturalStyle", mappedBy="building")
     */
    protected $architecturalStyles;

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
     * @OGM\Relationship(type="HasRaised", direction="INCOMING", targetEntity="Production", mappedBy="building")
     */
    protected $production;

    public function __construct()
    {
        $this->architecturalStyles = new Collection();
        $this->heritageResourceTypes = new Collection();
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
     * @return string
     */
    public function getCreatedAt()
    {
        return Carbon::instance($this->created_at)->toDateTimeString();
    }
    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return Carbon::instance($this->updated_at)->toDateTimeString();
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
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return HeritageResourceType
     */
    public function getHeritageResourceTypes()
    {
        return $this->heritageResourceTypes;
    }

    /**
     * @return array
     */
    public function getHeritageResourceTypeIds()
    {
        $types = [];
        foreach($this->heritageResourceTypes as $heritageResourceType) {
            $types[] = $heritageResourceType->getId();
        }
        return $types;
    }

    /**
     * @return ArchitecturalStyle[]|Collection
     */
    public function getArchitecturalStyles()
    {
        return $this->architecturalStyles;
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
