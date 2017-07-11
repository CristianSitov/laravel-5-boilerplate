<?php

namespace App\Events\Backend\Heritage;

use App\Models\Heritage\Resource;
use Illuminate\Queue\SerializesModels;

/**
 * Class ResourceCreated.
 */
class ResourceUpdated
{
    use SerializesModels;

    /**
     * @var Resource $resource
     */
    public $resource;

    /**
     * @param $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }
}
