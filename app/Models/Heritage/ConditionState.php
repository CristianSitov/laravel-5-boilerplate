<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="ConditionState")
 */
class ConditionState
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
     * @var ConditionDescription
     *
     * @OGM\Relationship(type="HasNote", direction="OUTGOING", targetEntity="ConditionDescription", mappedBy="conditionState")
     */
    protected $condition_description;

    /**
     * @var ConditionImage
     *
     * @OGM\Relationship(type="Represents", direction="OUTGOING", targetEntity="ConditionImage", mappedBy="conditionState")
     */
    protected $condition_image;

    /**
     * @var ConditionType
     *
     * @OGM\Relationship(type="HasType", direction="OUTGOING", targetEntity="ConditionType", mappedBy="conditionState")
     */
    protected $condition_type;

    /**
     * @var ThreatType
     *
     * @OGM\Relationship(type="HasType", direction="OUTGOING", targetEntity="ThreatType", mappedBy="conditionState")
     */
    protected $threat_type;

    /**
     * @var ConditionAssessment
     *
     * @OGM\Relationship(type="HasIdentified", direction="INCOMING", targetEntity="ConditionAssessment", mappedBy="conditionState")
     */
    protected $condition_assessment;

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
     * @return ConditionDescription
     */
    public function getConditionDescription()
    {
        return $this->condition_description;
    }

    /**
     * @param ConditionDescription $condition_description
     */
    public function setConditionDescription($condition_description)
    {
        $this->condition_description = $condition_description;
    }

    /**
     * @return ConditionImage
     */
    public function getConditionImage()
    {
        return $this->condition_image;
    }

    /**
     * @param ConditionImage $condition_image
     */
    public function setConditionImage($condition_image)
    {
        $this->condition_image = $condition_image;
    }

    /**
     * @return ConditionType
     */
    public function getConditionType()
    {
        return $this->condition_type;
    }

    /**
     * @param ConditionType $condition_type
     */
    public function setConditionType($condition_type)
    {
        $this->condition_type = $condition_type;
    }

    /**
     * @return ThreatType
     */
    public function getThreatType()
    {
        return $this->threat_type;
    }

    /**
     * @param ThreatType $threat_type
     */
    public function setThreatType($threat_type)
    {
        $this->threat_type = $threat_type;
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
}
