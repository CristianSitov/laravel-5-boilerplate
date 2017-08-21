<?php

namespace App\Models\Heritage;

use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * Class HadFormerOrCurrentResidence.
 *
 * @OGM\RelationshipEntity(type="HadFormerOrCurrentResidence")
 */
class HadFormerOrCurrentResidence
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
    protected $since;

    /**
     * @OGM\Property()
     *
     * @var string
     */
    protected $until;

    /**
     * HadFormerOrCurrentResidence constructor.
     *
     * @param Actor $owner
     * @param Resource $house
     * @param string $since
     * @param string $until
     */
    public function __construct(Actor $actor, Resource $resource = null, $since = null, $until = null)
    {
        $this->actor = $actor;
        $this->resource = $resource;
        $this->since = $since;
        $this->since = $until;
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
