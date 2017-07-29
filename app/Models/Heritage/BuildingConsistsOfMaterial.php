<?php

namespace App\Models\Heritage;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * Class BuildingConsistsOfMaterial.
 *
 * @OGM\RelationshipEntity(type="BuildingConsistsOfMaterial")
 */
class BuildingConsistsOfMaterial
{
    /**
     * @OGM\GraphId()
     *
     * @var int
     */
    protected $id;

    /**
     * @OGM\StartNode(targetEntity="Building")
     *
     * @var Building
     */
    protected $building;

    /**
     * @OGM\EndNode(targetEntity="Material")
     *
     * @var Material
     */
    protected $material;

    /**
     * @OGM\Property()
     *
     * @var string
     */
    protected $description;

    /**
     * Acquisition constructor.
     *
     * @param Building $building
     * @param Material $material
     * @param string   $description
     */
    public function __construct(Building $building, Material $material, $description)
    {
        $this->building = $building;
        $this->material = $material;
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

    /**
     * @return Material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param Material $material
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
