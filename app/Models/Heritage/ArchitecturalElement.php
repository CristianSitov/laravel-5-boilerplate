<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="ArchitecturalElement")
 */
class ArchitecturalElement
{
    use Uuids;

    const MAP = [
        'roof' => [
            'type' => ['multiple'],
            'cladding_material' => ['multiple'],
            'details' => ['multiple', 'mods', 'group'],
            'chimney_type' => ['single'],
            'chimney_material' => ['multiple', 'group'],
        ],
        'facade' => [
            'type' => ['single', 'group'],
            'cladding_cornice_material' => ['multiple'],
            'cornice_details' => ['multiple', 'mods', 'group'],
            'cladding_plain_material' => ['multiple'],
            'plain_details' => ['multiple', 'mods'],
            'plain_window_type' => ['multiple', 'mods', 'group'],
            'cladding_base_material' => ['multiple'],
            'base_details' => ['multiple', 'mods'],
            'base_window_type' => ['multiple', 'mods'],
            'plain_storefront_type' => ['multiple', 'mods', 'group'],
        ],
        'access' => [
            'door_type' => ['multiple', 'mods'],
            'entryway_type' => ['multiple', 'mods'],
            'portal_type' => ['multiple', 'mods', 'group'],
        ],
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
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $order;

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
    protected $set;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $aspect;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $aspect_ro;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $area;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $area_ro;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $value;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $value_ro;

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
    protected $modified;

    /**
     * @var Component
     *
     * @OGM\Relationship(type="HasProduced", direction="INCOMING", targetEntity="Component", mappedBy="architecturalElement")
     */
    protected $component;

    public function __construct($params = null)
    {
        if ($params) {
            foreach ($params as $k => $param) {
                $this->{$k} = $param;
            }
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
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
    public function getOrder()
    {
        return $this->order;
    }
    /**
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
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
     * @return Component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param Component $component
     */
    public function setComponent($component)
    {
        $this->component = $component;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @param string
     */
    public function setSet($set)
    {
        $this->set = $set;
    }

    /**
     * @return string
     */
    public function getAspect()
    {
        return $this->aspect;
    }

    /**
     * @param string
     */
    public function setAspect($aspect)
    {
        $this->aspect = $aspect;
    }

    /**
     * @return string
     */
    public function getAspectRo()
    {
        return $this->aspect_ro;
    }

    /**
     * @param string
     */
    public function setAspectRo($aspect_ro)
    {
        $this->aspect_ro = $aspect_ro;
    }

    /**
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param string
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * @return string
     */
    public function getAreaRo()
    {
        return $this->area_ro;
    }

    /**
     * @param string
     */
    public function setAreaRo($area_ro)
    {
        $this->area_ro = $area_ro;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValueRo()
    {
        return $this->value_ro;
    }

    /**
     * @param string
     */
    public function setValueRo($value_ro)
    {
        $this->value_ro = $value_ro;
    }

    /**
     * @return string
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param string
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    public function toArray() {
        return [
            'uuid' => $this->uuid,
            'order' => $this->order,
            'type' => $this->type,
            'set' => $this->set,
            'aspect' => $this->aspect,
            'aspect_ro' => $this->aspect_ro,
            'area' => $this->area,
            'area_ro' => $this->area_ro,
            'value' => $this->value,
            'value_ro' => $this->value_ro,
        ];
    }
}
