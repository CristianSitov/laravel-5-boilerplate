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
     * @var ResourceRepository
     */
    protected $resourceRepository;

    /**
     * @param ResourceRepository $resources
     */
    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @param HeritageResourceRequest $request
     *
     * @return mixed
     */
    public function __invoke(HeritageResourceRequest $request)
    {
        if (access()->hasRole('Administrator')) {
            $heritageResources = $this->resourceRepository->getForDataTable(false, false);
        } else if (access()->hasRole('Scout') || access()->hasRole('Desk')) {
            $heritageResources = $this->resourceRepository->getForDataTable(true, false);
        }

        return Datatables::of($heritageResources)
            ->escapeColumns(['address', 'name', 'status', 'progress'])
            ->make(true);
    }
}
