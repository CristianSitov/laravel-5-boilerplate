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
    protected $date_to;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $date_from;

    /**
     * @var ModificationDescription
     *
     * @OGM\Relationship(type="HasNote", direction="OUTGOING", targetEntity="ModificationDescription", mappedBy="modificationEvent")
     */
    protected $modificationDescription;

    /**
     * @var ModificationType
     *
     * @OGM\Relationship(type="HasType", direction="OUTGOING", targetEntity="ModificationType", mappedBy="modificationEvent")
     */
    protected $modificationType;

    /**
     * @var Modification
     *
     * @OGM\Relationship(type="HasModified", direction="INCOMING", targetEntity="Modification", mappedBy="modificationEvent")
     */
    protected $modification;

    public function __construct(ModificationType $modificationType, ModificationDescription $modificationDescription, $from = null, $to = null)
    {
        $this->modificationType = $modificationType;
        $this->modificationDescription = $modificationDescription;
        $this->date_from = $from;
        $this->date_to = $to;
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
    public function getDateFrom()
    {
        return $this->date_from;
    }
    /**
     * @param \DateTime $date_from
     */
    public function setDateFrom($date_from)
    {
        $this->date_from = $date_from;
    }

    /**
     * @return string
     */
    public function getDateTo()
    {
        return $this->date_to;
    }
    /**
     * @param \DateTime $date_to
     */
    public function setDateTo($date_to)
    {
        $this->date_to = $date_to;
    }

    /**
     * @return ModificationDescription
     */
    public function getModificationDescription()
    {
        return $this->modificationDescription;
    }

    /**
     * @param ModificationDescription $modificationDescription
     */
    public function setModificationDescription($modificationDescription)
    {
        $this->modificationDescription = $modificationDescription;
    }

    /**
     * @return ModificationType
     */
    public function getModificationType()
    {
        return $this->modificationType;
    }

    /**
     * @param ModificationType $modificationType
     */
    public function setModificationType($modificationType)
    {
        $this->modificationType = $modificationType;
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
