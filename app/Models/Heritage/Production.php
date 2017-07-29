<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="Production")
 */
class Production
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
     * @var Building
     *
     * @OGM\Relationship(type="HasRaised", direction="OUTGOING", targetEntity="Building", mappedBy="production")
     */
    protected $building;

    /**
     * @var ProductionEvent
     *
     * @OGM\Relationship(type="HasProducedEvent", direction="OUTGOING", targetEntity="ProductionEvent", mappedBy="production")
     */
    protected $productionEvent;

    /**
     * @var Resource
     *
     * @OGM\Relationship(type="HasProduced", direction="INCOMING", targetEntity="Resource", mappedBy="production")
     */
    protected $resource;

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
     * @return ProductionEvent
     */
    public function getProductionEvent()
    {
        return $this->productionEvent;
    }

    /**
     * @param ProductionEvent $production_event
     */
    public function setProductionEvent($production_event)
    {
        $this->productionEvent = $production_event;
    }

    /**
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param Resource $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }
}
