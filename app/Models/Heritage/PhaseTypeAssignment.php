<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="PhaseTypeAssignment")
 */
class PhaseTypeAssignment
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
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $name;

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
     * @var Production
     *
     * @OGM\Relationship(type="Classified", direction="INCOMING", targetEntity="PhaseTypeAssignment", mappedBy="phaseTypeAssignment")
     */
    protected $production;

    /**
     * @var ArchitecturalStyle
     *
     * @OGM\Relationship(type="HasArchitecturalStyleType", direction="OUTGOING", targetEntity="ArchitecturalStyle", mappedBy="phaseTypeAssignment")
     */
    protected $architectural_style;

    /**
     * @var HeritageResourceType
     *
     * @OGM\Relationship(type="Assigned", direction="OUTGOING", targetEntity="HeritageResourceType", mappedBy="phaseTypeAssignment")
     */
    protected $heritage_resource_type;

    /**
     * @var AncilaryFeatureType
     *
     * @OGM\Relationship(type="Assigned", direction="OUTGOING", targetEntity="AncilaryFeatureType", mappedBy="phaseTypeAssignment")
     */
    protected $ancilary_feature_type;

    /**
     * @var CulturalPeriod
     *
     * @OGM\Relationship(type="Assigned", direction="OUTGOING", targetEntity="CulturalPeriod", mappedBy="phaseTypeAssignment")
     */
    protected $cultural_period;

    /**
     * @var HeritageResourceUseType
     *
     * @OGM\Relationship(type="Assigned", direction="OUTGOING", targetEntity="HeritageResourceUseType", mappedBy="phaseTypeAssignment")
     */
    protected $heritage_resource_use_type;

    /**
     * @var TimeSpanPhase
     *
     * @OGM\Relationship(type="HasTimeSpan", direction="OUTGOING", targetEntity="TimeSpanPhase", mappedBy="phaseTypeAssignment")
     */
    protected $time_span_phase;

    /**
     * @var SubjectiveDescription
     *
     * @OGM\Relationship(type="HasSubjectiveDescription", direction="OUTGOING", targetEntity="SubjectiveDescription", mappedBy="phaseTypeAssignment")
     */
    protected $subjective_description;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Production
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param Production $production
     */
    public function setProduction($production)
    {
        $this->production = $production;
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
}
