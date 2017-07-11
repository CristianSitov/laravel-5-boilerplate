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
     * @var Description
     *
     * @OGM\Relationship(type="HasNote", direction="OUTGOING", targetEntity="Description", mappedBy="resource")
     */
    protected $description;

    /**
     * @var ResourceClassificationType
     *
     * @OGM\Relationship(type="HasClassificationType", direction="OUTGOING", targetEntity="ResourceClassificationType", mappedBy="resource")
     */
    protected $resourceClassificationType;

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
     * @return ResourceClassificationType $resource_classification_type
     */
    public function getResourceClassificationType()
    {
        return $this->resourceClassificationType;
    }

    /**
     * @param ResourceClassificationType $resource_classification_type
     */
    public function setResourceClassificationType($resource_classification_type)
    {
        $oldResourceClassificationType = $this->getResourceClassificationType();
        $this->resourceClassificationType = $resource_classification_type;
    }
}
