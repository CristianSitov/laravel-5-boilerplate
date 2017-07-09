<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Http\Transformers\HeritageResourceTransformer;
use GraphAware\Bolt\Result\Type\Node;
use League\Fractal;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Heritage\ResourceRepository;
use App\Http\Requests\Backend\Heritage\HeritageResourceRequest;

/**
 * Class ResourceTableController.
 */
class ResourceTableController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $resources;

    /**
     * @param UserRepository $resources
     */
    public function __construct(ResourceRepository $resources)
    {
        $this->resources = $resources;
    }

    /**
     * @param HeritageResourceRequest $request
     *
     * @return mixed
     */
    public function __invoke(HeritageResourceRequest $request)
    {
        $heritageResources = $this->resources->getForDataTable($request->get('status'), $request->get('trashed'));

        return Datatables::of($heritageResources)
            ->escapeColumns(['resource_uuid', 'description_description'])
//            ->addColumn('actions', function ($resource) {
//                return $resource->action_buttons;
//            })
            ->make(true);
    }
}
