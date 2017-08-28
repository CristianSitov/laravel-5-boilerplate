<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Attribute\ActorAttribute;
use GraphAware\Neo4j\OGM\Common\Collection;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="Actor")
 */
class Actor
{
    use ActorAttribute;

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
    protected $first_name;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $appelation;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $last_name;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $nick_name;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $description;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $description_ro;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $keywords;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $is_legal;

    /**
     * @var string
     *
     * @OGM\Property()
     */
    protected $date_birth;

    /**
     * @var string
     *
     * @OGM\Property()
     */
    protected $date_death;

    /**
     * @var string
     *
     * @OGM\Property()
     */
    protected $place_birth;

    /**
     * @var string
     *
     * @OGM\Property()
     */
    protected $place_death;

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
    protected $deleted_at;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $published_at;

    /**
     * @OGM\Relationship(relationshipEntity="IsRelatedTo", type="IsRelatedTo", direction="OUTGOING", collection=true, mappedBy="actor")
     *
     * @var IsRelatedTo[]|Collection
     */
    protected $isRelatedTo;

    const RELS = [
        'architect',
        'constructor',
        'owner',
        'former_owner',
        'administrator',
        'former_administrator',
        'tenant',
        'former_tenant',
    ];

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
    public function getAppelation()
    {
        return $this->appelation;
    }

    /**
     * @param string $appelation
     */
    public function setAppelation($appelation)
    {
        $this->appelation = $appelation;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getNickName()
    {
        return $this->nick_name;
    }

    /**
     * @param string $nick_name
     */
    public function setNickName($nick_name)
    {
        $this->nick_name = $nick_name;
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

    /**
     * @return string
     */
    public function getDescriptionRo()
    {
        return $this->description_ro;
    }

    /**
     * @param string $description_ro
     */
    public function setDescriptionRo($description_ro)
    {
        $this->description_ro = $description_ro;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getIsLegal()
    {
        return $this->is_legal;
    }

    /**
     * @param string $is_legal
     */
    public function setIsLegal($is_legal)
    {
        $this->is_legal = $is_legal;
    }

    /**
     * @return string
     */
    public function getDateBirth()
    {
        return $this->date_birth;
    }
    /**
     * @param string $date_birth
     */
    public function setDateBirth($date_birth)
    {
        $this->date_birth = $date_birth;
    }

    /**
     * @return string
     */
    public function getPlaceBirth()
    {
        return $this->place_birth;
    }
    /**
     * @param string $place_birth
     */
    public function setPlaceBirth($place_birth)
    {
        $this->place_birth = $place_birth;
    }

    /**
     * @return string
     */
    public function getDateDeath()
    {
        return $this->date_death;
    }
    /**
     * @param string $date_death
     */
    public function setDateDeath($date_death)
    {
        $this->date_death = $date_death;
    }

    /**
     * @return string
     */
    public function getPlaceDeath()
    {
        return $this->place_death;
    }
    /**
     * @param string $place_death
     */
    public function setPlaceDeath($place_death)
    {
        $this->place_death = $place_death;
    }

    /**
     * @return Collection|IsRelatedTo[]
     */
    public function getIsRelatedTo()
    {
        return $this->isRelatedTo;
    }

    /**
     * @return IsRelatedTo
     */
    public function getIsRelatedToById($id)
    {
        $relationships = $this->isRelatedTo;

        $result = null;
        foreach ($relationships as $relationship) {
            if ($id == $relationship->getId()) {
                $result = $relationship;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getIsRelatedToIds()
    {
        $relationships = $this->isRelatedTo;

        $results = [];
        if ($relationships) {
            foreach ($relationships as $relationship) {
                $results[] = $relationship->getId();
            }
        }

        return $results;
    }
}
