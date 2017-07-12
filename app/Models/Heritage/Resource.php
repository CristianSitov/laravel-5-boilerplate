<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Attribute\ResourceAttribute;
use Carbon\Carbon;
use GraphAware\Neo4j\OGM\Annotations as OGM;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resource
 *
 * @OGM\Node(label="Resource")
 */
class Resource extends Model
{
    use ResourceAttribute;

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
     * @var Name
     *
     * @OGM\Relationship(type="IsIdentifiedBy", direction="OUTGOING", targetEntity="Name", mappedBy="resource")
     */
    protected $name;

    /**
     * @var Description
     *
     * @OGM\Relationship(type="HasNote", direction="OUTGOING", targetEntity="Description", mappedBy="resource")
     */
    protected $description;

    /**
     * @var ResourceTypeClassification
     *
     * @OGM\Relationship(type="HasResourceTypeClassification", direction="OUTGOING", targetEntity="ResourceTypeClassification", mappedBy="resource")
     */
    protected $resourceTypeClassification;

    /**
     * @var Place
     *
     * @OGM\Relationship(type="HasCurrentLocation", direction="OUTGOING", targetEntity="Place", mappedBy="resource")
     */
    protected $place;

    /**
     * @var Production
     *
     * @OGM\Relationship(type="HasProduced", direction="OUTGOING", targetEntity="Production", mappedBy="resource")
     */
    protected $production;

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
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param Description $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return ResourceTypeClassification
     */
    public function getResourceTypeClassification()
    {
        return $this->resourceTypeClassification;
    }

    /**
     * @param ResourceTypeClassification $resource_type_classification
     */
    public function setResourceTypeClassification($resource_type_classification)
    {
        $this->resourceTypeClassification = $resource_type_classification;
    }

    /**
     * @return Place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param Place $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return Production
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param Production $production
     */
    public function setProduction($production)
    {
        $this->production = $production;
    }
}
