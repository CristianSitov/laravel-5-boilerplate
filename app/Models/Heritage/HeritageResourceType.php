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
    protected $set;

    /**
     * @var int
     *
     * @OGM\Property(type="int")
     */
    protected $set_order;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $set_ro;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $name;

    /**
     * @var int
     *
     * @OGM\Property(type="int")
     */
    protected $name_order;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $name_ro;

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
     * @var Building
     *
     * @OGM\Relationship(type="Assigned", direction="INCOMING", targetEntity="Building", mappedBy="heritageResourceType")
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
     * @return int
     */
    public function getNameOrder()
    {
        return $this->name_order;
    }

    /**
     * @param int $name_order
     */
    public function setNameOrder($name_order)
    {
        $this->name_order = $name_order;
    }

    /**
     * @return string
     */
    public function getNameRo()
    {
        return $this->name_ro;
    }

    /**
     * @param string $name_ro
     */
    public function setNameRo($name_ro)
    {
        $this->name_ro = $name_ro;
    }

    /**
     * @return string
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @param string $set
     */
    public function setSet($set)
    {
        $this->set = $set;
    }

    /**
     * @return int
     */
    public function getSetOrder()
    {
        return $this->set_order;
    }

    /**
     * @param int $set_order
     */
    public function setSetOrder($set_order)
    {
        $this->set_order = $set_order;
    }

    /**
     * @return string
     */
    public function getSetRo()
    {
        return $this->set_ro;
    }

    /**
     * @param string $set_ro
     */
    public function setSetRo($set_ro)
    {
        $this->set_ro = $set_ro;
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
