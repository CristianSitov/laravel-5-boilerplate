<?php

namespace App\Models\Heritage;

use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * Class IsRelatedTo.
 *
 * @OGM\RelationshipEntity(type="IsRelatedTo")
 */
class IsRelatedTo
{
    /**
     * @OGM\GraphId()
     *
     * @var int
     */
    protected $id;

    /**
     * @OGM\StartNode(targetEntity="Actor")
     *
     * @var Actor
     */
    protected $actor;

    /**
     * @OGM\EndNode(targetEntity="Resource")
     *
     * @var Resource
     */
    protected $resource;

    /**
     * @OGM\Property()
     *
     * @var string
     */
    protected $relation;

    /**
     * @OGM\Property()
     *
     * @var string
     */
    protected $since;

    /**
     * @OGM\Property()
     *
     * @var string
     */
    protected $until;

    /**
     * HadCustodyOf constructor.
     *
     * @param Actor $owner
     * @param Resource $house
     * @param string $since
     * @param string $until
     */
    public function __construct(Actor $actor, Resource $resource = null, $relation = null, $since = null, $until = null, $main = null)
    {
        $this->actor = $actor;
        $this->resource = $resource;
        $this->relation = $relation;
        $this->since = $since;
        $this->until = $until;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @param Actor $actor
     */
    public function setActor($actor)
    {
        $this->actor = $actor;
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
     * @return string
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @param string $relation
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    /**
     * @return string
     */
    public function getSince()
    {
        return $this->since;
    }

    /**
     * @param string $since
     */
    public function setSince($since)
    {
        $this->since = $since;
    }

    /**
     * @return string
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @param string $until
     */
    public function setUntil($until)
    {
        $this->until = $until;
    }
}
