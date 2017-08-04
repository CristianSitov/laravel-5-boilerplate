<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="Modification")
 */
class Modification
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
     * @var ModificationEvent
     *
     * @OGM\Relationship(type="HasModified", direction="OUTGOING", targetEntity="ModificationEvent", mappedBy="modification")
     */
    protected $modificationEvent;

    /**
     * @var Building
     *
     * @OGM\Relationship(type="HasModifiedBuilding", direction="INCOMING", targetEntity="Building", mappedBy="modification")
     */
    protected $building;

    /**
     * @var Component
     *
     * @OGM\Relationship(type="HasModifiedComponent", direction="INCOMING", targetEntity="Component", mappedBy="modification")
     */
    protected $component;

    public function __construct(ModificationEvent $modificationEvent = null)
    {
        $this->modificationEvent = $modificationEvent;
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
     * @return ModificationEvent
     */
    public function getModificationEvent()
    {
        return $this->modificationEvent;
    }

    /**
     * @param ModificationEvent $modificationEvent
     */
    public function setModificationEvent($modificationEvent)
    {
        $this->modificationEvent = $modificationEvent;
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
}
