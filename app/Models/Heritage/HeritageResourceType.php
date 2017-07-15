<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="HeritageResourceType")
 */
class HeritageResourceType
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
    protected $main;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $type_set;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $type_set_ro;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $type;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $type_ro;

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
     * @var Building
     *
     * @OGM\Relationship(type="Assigned", direction="INCOMING", targetEntity="Building", mappedBy="building")
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
     * @return string
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param string $main
     */
    public function setMain($main)
    {
        $this->main = $main;
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
     * @return string
     */
    public function getTypeRo()
    {
        return $this->type_ro;
    }

    /**
     * @param string $type_ro
     */
    public function setTypeRo($type_ro)
    {
        $this->type_ro = $type_ro;
    }

    /**
     * @return string
     */
    public function getTypeSet()
    {
        return $this->type_set;
    }

    /**
     * @param string $type_set
     */
    public function setTypeSet($type_set)
    {
        $this->type_set = $type_set;
    }

    /**
     * @return string
     */
    public function getTypeSetRo()
    {
        return $this->type_set_ro;
    }

    /**
     * @param string $type_set_ro
     */
    public function setTypeSetRo($type_set_ro)
    {
        $this->type_set_ro = $type_set_ro;
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
