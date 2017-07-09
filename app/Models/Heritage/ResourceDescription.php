<?php

namespace App\Models\Heritage;

use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\RelationshipEntity(type="HasNote")
 */
class ResourceDescription
{
    /**
     * @var int
     *
     * @OGM\GraphId()
     */
    protected $id;

    /**
     * @var HeritageResource
     *
     * @OGM\StartNode(targetEntity="HeritageResource")
     */
    protected $resource;

    /**
     * @var Description
     *
     * @OGM\EndNode(targetEntity="Description")
     */
    protected $description;

    public function __construct(HeritageResource $resource, Description $description)
    {
        $this->resource = $resource;
        $this->description = $description;
    }

    /**
     * @return HeritageResource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return Description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
