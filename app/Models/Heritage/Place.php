<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="Place")
 */
class Place
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
     * @var AdministrativeSubdivision
     *
     * @OGM\Relationship(type="IsIncorporatedIn", direction="OUTGOING", targetEntity="AdministrativeSubdivision", mappedBy="place")
     */
    protected $administrative_subdivision;

    /**
     * @var PlaceAddress
     *
     * @OGM\Relationship(type="IsIdentifiedBy", direction="OUTGOING", targetEntity="PlaceAddress", mappedBy="place")
     */
    protected $place_address;

    /**
     * @var Resource
     *
     * @OGM\Relationship(type="HasCurrentLocation", direction="INCOMING", targetEntity="Resource", mappedBy="place")
     */
    protected $resource;

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

    /**
     * @return AdministrativeSubdivision
     */
    public function getAdministrativeSubdivision()
    {
        return $this->administrative_subdivision;
    }

    /**
     * @param AdministrativeSubdivision $administrative_subdivision
     */
    public function setAdministrativeSubdivision($administrative_subdivision)
    {
        $this->administrative_subdivision = $administrative_subdivision;
    }

    /**
     * @return PlaceAddress
     */
    public function getPlaceAddress()
    {
        return $this->place_address;
    }

    /**
     * @param PlaceAddress $place_address
     */
    public function setPlaceAddress($place_address)
    {
        $this->place_address = $place_address;
    }
}
