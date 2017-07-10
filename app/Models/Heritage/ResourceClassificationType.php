<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Attribute\ResourceAttribute;
use GraphAware\Neo4j\OGM\Annotations as OGM;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OGM\Node(label="ResourceClassificationType")
 */
class ResourceClassificationType extends Model
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
    protected $type;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $note;

    /**
     * @OGM\Label(name="Published")
     *
     * @var bool
     */
    protected $published;

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
     * @OGM\Relationship(type="HasClassificationType", direction="INCOMING", targetEntity="Resource", mappedBy="classification_type")
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $note
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return (bool) $this->published;
    }

    /**
     * @param mixed $published
     */
    public function setPublished($published)
    {
        $this->published =  (bool) $published;
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
}
