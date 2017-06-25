<?php

namespace App\Events\Backend\Heritage;

use Illuminate\Queue\SerializesModels;

/**
 * Class ResourceCreated.
 */
class ResourceCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @param $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }
}
