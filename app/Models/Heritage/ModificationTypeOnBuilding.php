<?php

namespace App\Models\Heritage;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * Class ModificationTypeOnBuilding.
 *
 * @OGM\RelationshipEntity(type="ModificationTypeOnBuilding")
 */
class ModificationTypeOnBuilding
{
    /**
     * @OGM\GraphId()
     *
     * @var int
     */
    protected $id;

    /**
     * @OGM\StartNode(targetEntity="ModificationType")
     *
     * @var ModificationType
     */
    protected $modificationType;

    /**
     * ModificationTypeOnBuilding constructor.
     *
     * @param ModificationType $modificationType
     * @param Building $building
     * @param string $description
     */
    public function __construct(ModificationType $modificationType, Building $building, $description)
    {
        $this->modificationType = $modificationType;
        $this->building = $building;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ModificationType
     */
    public function getModificationType()
    {
        return $this->modificationType;
    }

    /**
     * @param ModificationType $modificationType
     */
    public function setModificationType($modificationType)
    {
        $this->modificationType = $modificationType;
    }

    /**
     * @return Building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param Building $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    }
}
