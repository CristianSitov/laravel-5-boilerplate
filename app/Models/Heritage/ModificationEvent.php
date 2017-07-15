<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="ModificationEvent")
 */
class ModificationEvent
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
    protected $to_date;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $from_date;

    /**
     * @var ModificationDescription
     *
     * @OGM\Relationship(type="HasNote", direction="OUTGOING", targetEntity="ModificationDescription", mappedBy="modificationEvent")
     */
    protected $modification_description;

    /**
     * @var ModificationType
     *
     * @OGM\Relationship(type="HasType", direction="OUTGOING", targetEntity="ModificationType", mappedBy="modificationEvent")
     */
    protected $modification_type;

    /**
     * @var Modification
     *
     * @OGM\Relationship(type="HasModified", direction="INCOMING", targetEntity="Modification", mappedBy="modificationEvent")
     */
    protected $modification;

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
    public function getToDate()
    {
        return $this->to_date;
    }

    /**
     * @param \DateTime $to_date
     */
    public function setToDate($to_date)
    {
        $this->to_date = $to_date;
    }

    /**
     * @return \DateTime
     */
    public function getFromDate()
    {
        return $this->from_date;
    }

    /**
     * @param \DateTime $from_date
     */
    public function setFromDate($from_date)
    {
        $this->from_date = $from_date;
    }

    /**
     * @return ModificationDescription
     */
    public function getModificationDescription()
    {
        return $this->modification_description;
    }

    /**
     * @param ModificationDescription $modification_description
     */
    public function setModificationDescription($modification_description)
    {
        $this->modification_description = $modification_description;
    }

    /**
     * @return ModificationType
     */
    public function getModificationType()
    {
        return $this->modification_type;
    }

    /**
     * @param ModificationType $modification_type
     */
    public function setModificationType($modification_type)
    {
        $this->modification_type = $modification_type;
    }

    /**
     * @return Modification
     */
    public function getModification()
    {
        return $this->modification;
    }

    /**
     * @param Modification $modification
     */
    public function setModification($modification)
    {
        $this->modification = $modification;
    }
}
