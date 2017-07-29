<?php

namespace App\Http\Controllers\Backend\Heritage\ResourceTypeClassification;

use App\Http\Controllers\Controller;
use App\Http\Transformers\HeritageResourceTransformer;
use App\Repositories\Backend\Heritage\ResourceTypeClassificationRepository;
use GraphAware\Bolt\Result\Type\Node;
use League\Fractal;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Heritage\ResourceRepository;
use App\Http\Requests\Backend\Heritage\HeritageResourceRequest;

/**
 * Class ResourceTableController.
 */
class ResourceTypeClassificationTableController extends Controller
{
    /**
     * @var ResourceRepository
     */
    protected $resourceTypeClassificationRepository;

    /**
     * @param ResourceTypeClassificationRepository $resourceClassificationType
     */
    public function __construct(ResourceTypeClassificationRepository $resourceTypeClassificationRepository)
    {
        $this->resourceTypeClassificationRepository = $resourceTypeClassificationRepository;
    }

    /**
     * @param HeritageResourceRequest $request
     *
     * @return mixed
     */
    public function __invoke(HeritageResourceRequest $request)
    {
        $resourceTypeClassifications = $this->resourceTypeClassificationRepository
            ->getForDataTable($request->get('status'), $request->get('trashed'));

        return Datatables::of($resourceTypeClassifications)
            ->escapeColumns(['type_set', 'type'])
            ->make(true);
    }
}
