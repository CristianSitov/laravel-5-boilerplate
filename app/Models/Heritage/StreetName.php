<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="StreetName")
 */
class StreetName
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
    protected $current_name;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $former_name;

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
    protected $document;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $district;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $guide_area;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $year_1956;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $year_1946;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $year_1940;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $year_1936;

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
     * @var PlaceAddress
     *
     * @OGM\Relationship(type="IsIdentifiedBy", direction="INCOMING", targetEntity="PlaceAddress", mappedBy="placeAddress")
     */
    protected $placeAddress;

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
    public function getCurrentName()
    {
        return $this->current_name;
    }

    /**
     * @param string $current_name
     */
    public function setCurrentName($current_name)
    {
        $this->current_name = $current_name;
    }

    /**
     * @return string
     */
    public function getFormerName()
    {
        return $this->former_name;
    }

    /**
     * @param string $former_name
     */
    public function setFormerName($former_name)
    {
        $this->former_name = $former_name;
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
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param string $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return string
     */
    public function getGuideArea()
    {
        return $this->guide_area;
    }

    /**
     * @param string $guide_area
     */
    public function setGuideArea($guide_area)
    {
        $this->guide_area = $guide_area;
    }

    /**
     * @return string
     */
    public function getYear1956()
    {
        return $this->year_1956;
    }

    /**
     * @param string $year_1956
     */
    public function setYear1956($year_1956)
    {
        $this->year_1956 = $year_1956;
    }

    /**
     * @return string
     */
    public function getYear1946()
    {
        return $this->year_1946;
    }

    /**
     * @param string $year_1946
     */
    public function setYear1946($year_1946)
    {
        $this->year_1946 = $year_1946;
    }

    /**
     * @return string
     */
    public function getYear1940()
    {
        return $this->year_1940;
    }

    /**
     * @param string $year_1940
     */
    public function setYear1940($year_1940)
    {
        $this->year_1940 = $year_1940;
    }

    /**
     * @return string
     */
    public function getYear1936()
    {
        return $this->year_1936;
    }

    /**
     * @param string $year_1936
     */
    public function setYear1936($year_1936)
    {
        $this->year_1936 = $year_1936;
    }

    /**
     * @return PlaceAddress
     */
    public function getPlaceAddress()
    {
        return $this->placeAddress;
    }

    /**
     * @param PlaceAddress $placeAddress
     */
    public function setPlaceAddress($placeAddress)
    {
        $this->placeAddress = $placeAddress;
    }
}
