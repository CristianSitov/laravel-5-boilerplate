<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="LegalDocument")
 */
class LegalDocument
{
    const TYPES = [
        'building_approval'
    ];

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
     * @var boolean
     *
     * @OGM\Property(type="boolean")
     */
    protected $type;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $date_from;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $date_to;

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
     * @var Resource
     *
     * @OGM\Relationship(type="IsDocumentedBy", direction="INCOMING", targetEntity="Resource", mappedBy="legalDocument")
     */
    protected $resource;

    /**
     * Name constructor.
     *
     * @param string $name
     * @param string $from
     * @param string $to
     */
    public function __construct($name = null, $type = null, $from = null, $to = null)
    {
        $this->name = $name;
        $this->type = $type;
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
     * @return boolean
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param boolean $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public static function getPossibleTypes()
    {
        $types = [];

        foreach (self::TYPES as $type) {
            $types[$type] = trans('validation.attributes.backend.heritage.resources.' . $type);
        }

        return $types;
    }

    /**
     * @return string
     */
    public function getDateFrom()
    {
        return $this->date_from;
    }
    /**
     * @param string $date_from
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
     * @param string $date_to
     */
    public function setDateTo($date_to)
    {
        $this->date_to = $date_to;
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
