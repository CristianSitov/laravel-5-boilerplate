<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Attribute\ResourceAttribute;
use Carbon\Carbon;
use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resource
 *
 * @OGM\Node(label="Resource")
 */
class Resource extends Model
{
    use ResourceAttribute;

    const PROPERTY = [
        'private',
        'public',
        'public_private',
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
     * @OGM\Property(nullable=true)
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @OGM\Property(nullable=true)
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $updated_at;

    /**
     * @var \DateTime
     *
     * @OGM\Property(nullable=true)
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $published_at;

    /**
     * @var \DateTime
     *
     * @OGM\Property(nullable=true)
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $deleted_at;

    /**
     * @var Name[]|Collection
     *
     * @OGM\Relationship(type="IsIdentifiedBy", direction="OUTGOING", targetEntity="Name", collection=true, mappedBy="resource")
     */
    protected $names;

    /**
     * @var ProtectionType[]|Collection
     *
     * @OGM\Relationship(type="HasProtectionType", direction="OUTGOING", targetEntity="ProtectionType", collection=true, mappedBy="resource")
     */
    protected $protectionTypes;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $propertyType;

    /**
     * @var Description
     *
     * @OGM\Relationship(type="HasNote", direction="OUTGOING", targetEntity="Description", mappedBy="resource")
     */
    protected $description;

    /**
     * @var ResourceTypeClassification
     *
     * @OGM\Relationship(type="HasResourceTypeClassification", direction="OUTGOING", targetEntity="ResourceTypeClassification", mappedBy="resource")
     */
    protected $resourceTypeClassification;

    /**
     * @var LegalDocument[]|Collection
     *
     * @OGM\Relationship(type="IsDocumentedBy", direction="OUTGOING", targetEntity="LegalDocument", collection=true, mappedBy="resource")
     */
    protected $legalDocuments;

    /**
     * @var Place
     *
     * @OGM\Relationship(type="HasCurrentLocation", direction="OUTGOING", targetEntity="Place", mappedBy="resource")
     */
    protected $place;

    /**
     * @var Production[]|Collection
     *
     * @OGM\Relationship(type="HasProduced", direction="OUTGOING", targetEntity="Production", collection=true, mappedBy="resource")
     */
    protected $productions;

    /**
     * @var Modification[]|Collection
     *
     * @OGM\Relationship(type="HasModified", direction="OUTGOING", targetEntity="Modification", collection=true, mappedBy="resource")
     */
    protected $modifications;

    /**
     * @OGM\Relationship(relationshipEntity="IsRelatedTo", type="IsRelatedTo", direction="INCOMING", collection=true, mappedBy="resource")
     *
     * @var IsRelatedTo[]|Collection
     */
    protected $isRelatedTo;

    public function __construct()
    {
        $this->status = 'field_ready';
        $this->published_at = null;
        $this->names = new Collection();
        $this->protectionTypes = new Collection();
        $this->productions = new Collection();
        $this->modifications = new Collection();
        $this->legalDocuments = new Collection();
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
     * @return string
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
     * @return string
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
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
    /**
     * @param \DateTime $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * @return Name[]|Collection
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @return Name|false
     */
    public function getCurrentName()
    {
        $names = $this->getNames();
        foreach ($names as $name) {
            if ($name->getCurrent()) {
                return $name;
            }
        }

        return false;
    }

    /**
     * @return ProtectionType[]|Collection
     */
    public function getProtectionTypes()
    {
        return $this->protectionTypes;
    }

    /**
     * @return ProtectionType|false
     */
    public function getCurrentProtectionType()
    {
        $protectionTypes = $this->getProtectionTypes();
        foreach ($protectionTypes as $protectionType) {
            if ($protectionType->getCurrent()) {
                return $protectionType;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * @param string $propertyType
     */
    public function setPropertyType($propertyType)
    {
        $this->propertyType = $propertyType;
    }

    /**
     * @return array
     */
    public static function getPropertyTypeOptions()
    {
        $types = [];

        foreach (self::PROPERTY as $type) {
            $types[$type] = trans('validation.attributes.backend.heritage.resources.' . $type);
        }

        return $types;
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
     * @return ResourceTypeClassification
     */
    public function getResourceTypeClassification()
    {
        return $this->resourceTypeClassification;
    }

    /**
     * @param ResourceTypeClassification $resource_type_classification
     */
    public function setResourceTypeClassification($resource_type_classification)
    {
        $this->resourceTypeClassification = $resource_type_classification;
    }

    /**
     * @return Place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param Place $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return Production[]|Collection
     */
    public function getProductions()
    {
        return $this->productions;
    }

    public function getProductionById($id)
    {
        foreach ($this->getProductions() as $production) {
            if ($production->getId() === $id) {
                return $production;
            }
        }

        return null;
    }

    /**
     * @return LegalDocument[]|Collection
     */
    public function getLegalDocuments()
    {
        return $this->legalDocuments;
    }

    /**
     * @return Collection|IsRelatedTo[]
     */
    public function getIsRelatedTo()
    {
        return $this->isRelatedTo;
    }
    /**
     * @param IsRelatedTo $isRelatedTo
     */
    public function setIsRelatedTo($isRelatedTo)
    {
        $this->isRelatedTo = $isRelatedTo;
    }
}
