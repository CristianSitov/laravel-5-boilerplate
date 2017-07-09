<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Common\Collection;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="HeritageResource")
 */
class HeritageResource
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
     * @var Description[]
     *
     * @OGM\Relationship(type="HasNote", direction="OUTGOING", collection=false, mappedBy="description", targetEntity="Description")
     */
    protected $description;

    public function __construct(Description $description)
    {
        $this->description = $description;
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
     * @return Description[]
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param Description[]
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
