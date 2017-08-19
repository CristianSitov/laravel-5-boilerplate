<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="Building")
 */
class Building
{
    use Uuids;

    const TYPES = [
        'main',
        'out'
    ];

    const LEVELS = [
        'basement',
        'semi_basement',
        'groud_floor',
        'first_floor',
        'second_floor',
        'third_floor',
        'fourth_floor',
        'attic',
        'mansard',
        'terrace',
        'other',
    ];

    const PLANS = [
        'rectangular',
        'rectangular_complex',
        'square',
        'triangular',
        'polygonal',
        'circular',
        'irregular',
        'unknown',
        'octagonal',
        'h_shaped',
        'l_shaped',
        't_shaped',
        'u_shaped',
    ];

    const PLANS_DESC = [
        'rectangular_complex',
        'polygonal',
        'irregular',
        'unknown',
    ];

    const CONDITIONS = [
        'very_good',
        'good',
        'fair',
        'poor',
        'very_bad',
        'other',
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
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $published_at;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $cardinality;

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
    protected $levels;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $notes;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $condition;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $condition_notes;

    /**
     * @var HeritageResourceType
     * @todo - add multiple here & even ancilaryFeatureType
     * @OGM\Relationship(type="Assigned", direction="OUTGOING", collection=true, targetEntity="HeritageResourceType", mappedBy="building")
     */
    protected $heritageResourceTypes;

    /**
     * @var ArchitecturalStyle[]|Collection
     *
     * @OGM\Relationship(type="HasArchitecturalStyleType", direction="OUTGOING", collection=true, targetEntity="ArchitecturalStyle", mappedBy="building")
     */
    protected $architecturalStyles;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $plan;

    /**
     * @var Component[]|Collection
     *
     * @OGM\Relationship(type="IsComposedOf", direction="OUTGOING", collection=true, targetEntity="Component", mappedBy="building")
     * @OGM\OrderBy(property="order", order="ASC")
     */
    protected $components;

    /**
     * @var BuildingConsistsOfMaterial[]|Collection
     *
     * @OGM\Relationship(relationshipEntity="BuildingConsistsOfMaterial", type="BuildingConsistsOfMaterial", direction="OUTGOING", collection=true, mappedBy="building")
     */
    protected $buildingConsistsOfMaterials;

    /**
     * @var Production
     *
     * @OGM\Relationship(type="HasRaised", direction="INCOMING", targetEntity="Production", mappedBy="building")
     */
    protected $production;

    /**
     * @var Modification[]|Collection
     *
     * @OGM\Relationship(type="HasModifiedBuilding", direction="OUTGOING", collection=true, targetEntity="Modification", mappedBy="building")
     */
    protected $modifications;

    public function __construct()
    {
        $this->components = new Collection();
        $this->buildingConsistsOfMaterials = new Collection();
        $this->architecturalStyles = new Collection();
        $this->heritageResourceTypes = new Collection();
        $this->modifications = new Collection();
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
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->published_at;
    }
    /**
     * @param \DateTime $published_at
     */
    public function setPublishedAt($published_at)
    {
        $this->published_at = $published_at;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCardinality()
    {
        return $this->cardinality;
    }

    /**
     * @param string $order
     */
    public function setCardinality($cardinality)
    {
        $this->cardinality = $cardinality;
    }

    /**
     * @return array
     */
    public function getLevels()
    {
        return explode(",", $this->levels);
    }

    /**
     * @param array $levels
     */
    public function setLevels($levels)
    {
        $this->levels = implode(",", array_intersect(self::LEVELS, $levels));
    }

    /**
     * @return string
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param string $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return string
     */
    public function getConditionNotes()
    {
        return $this->condition_notes;
    }

    /**
     * @param string $condition_notes
     */
    public function setConditionNotes($condition_notes)
    {
        $this->condition_notes = $condition_notes;
    }

    /**
     * @return HeritageResourceType[]|Collection
     */
    public function getHeritageResourceTypes()
    {
        return $this->heritageResourceTypes;
    }

    /**
     * @return array
     */
    public function getHeritageResourceTypeIds()
    {
        $types = [];
        foreach($this->heritageResourceTypes as $heritageResourceType) {
            $types[] = $heritageResourceType->getUuid();
        }

        return $types;
    }

    /**
     * @return array
     */
    public function getHeritageResourceTypeNotes()
    {
        $notes = '';
        foreach($this->heritageResourceTypes as $heritageResourceType) {
            if ($heritageResourceType->getType() == 'describe') {
                // only one for the moment :(
                $notes = $heritageResourceType->getNote();
            }
        }

        return $notes;
    }

    /**
     * @return ArchitecturalStyle[]|Collection
     */
    public function getArchitecturalStyles()
    {
        return $this->architecturalStyles;
    }

    /**
     * @return array
     */
    public function getArchitecturalStyleIds()
    {
        $styles = [];
        foreach($this->architecturalStyles as $architecturalStyle) {
            $styles[] = $architecturalStyle->getUuid();
        }
        return $styles;
    }

    /**
     * @return array
     */
    public function getArchitecturalStyleNotes()
    {
        $styles = '';
        foreach($this->architecturalStyles as $architecturalStyle) {
            if ($architecturalStyle->getType() == 'describe') {
                // only one for the moment :(
                $styles = $architecturalStyle->getNote();
            }
        }

        return $styles;
    }

    /**
     * @return Component[]|Collection
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @return Component[]|Collection
     */
    public function getComponentsByType($type)
    {
        $components = [];

        foreach ($this->getComponents() as $component) {
            if ($component->getType() === $type) {
                $components[] = $component;
            }
        }

        return $components;
    }

    /**
     * @return BuildingConsistsOfMaterial[]|Collection
     */
    public function getBuildingConsistsOfMaterials()
    {
        return $this->buildingConsistsOfMaterials;
    }

    /**
     * @return array
     */
    public function getBuildingConsistsOfMaterialIds()
    {
        $buildingConsistsOfMaterials = [];
        foreach($this->buildingConsistsOfMaterials as $buildingConsistsOfMaterial) {
            $buildingConsistsOfMaterials[] = $buildingConsistsOfMaterial->getMaterial()->getId();
        }
        return $buildingConsistsOfMaterials;
    }

    /**
     * @return Production
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param Resource $production
     */
    public function setProduction($production)
    {
        $this->production = $production;
    }

    /**
     * @return Modification[]|Collection
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    /**
     * @return array
     */
    public function getModificationsIds()
    {
        $modifications = [];
        foreach($this->modifications as $modification) {
            $modification[] = $modification->getId();
        }
        return $modifications;
    }

    /**
     * @return Modification|null
     */
    public function getModificationById($id)
    {
        foreach ($this->getModifications() as $modification) {
            if ($modification->getId() === $id) {
                return $modification;
            }
        }

        return null;
    }
}
