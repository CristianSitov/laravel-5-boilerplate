<?php

namespace App\Models\Heritage;

use App\Models\Heritage\Traits\Columns\Uuids;
use GraphAware\Neo4j\OGM\Annotations as OGM;
use Carbon\Carbon;

/**
 *
 * @OGM\Node(label="ProductionEvent")
 */
class ProductionEvent
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
    protected $to_date;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     * @OGM\Convert(type="datetime", options={"format":"timestamp"})
     */
    protected $from_date;

    /**
     * @var Production
     *
     * @OGM\Relationship(type="HasProducedEvent", direction="INCOMING", targetEntity="Production", mappedBy="productionEvent")
     */
    public $production;

    public function __construct($date_from = null, $date_to = null)
    {
        $this->from_date = $date_from;
        $this->to_date = $date_to;
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
     * @return string
     */
    public function getToDate()
    {
        return Carbon::instance($this->to_date)->format('Y/m/d');
    }

    /**
     * @param \DateTime $to_date
     */
    public function setToDate($to_date)
    {
        $this->to_date = $to_date;
    }

    /**
     * @return string
     */
    public function getFromDate()
    {
        return Carbon::instance($this->from_date)->format('Y/m/d');
    }

    /**
     * @return \DateTime
     */
    public function setFromDate($from_date)
    {
        $this->from_date = $from_date;
    }

    /**
     * @return Production
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param Production $production
     */
    public function setProduction($production)
    {
        $this->production = $production;
    }
}
