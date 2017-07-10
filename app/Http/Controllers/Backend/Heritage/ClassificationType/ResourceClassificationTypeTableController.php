<?php

namespace App\Http\Controllers\Backend\Heritage\ClassificationType;

use App\Http\Controllers\Controller;
use App\Http\Transformers\HeritageResourceTransformer;
use App\Repositories\Backend\Heritage\ResourceClassificationTypeRepository;
use GraphAware\Bolt\Result\Type\Node;
use League\Fractal;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Heritage\ResourceRepository;
use App\Http\Requests\Backend\Heritage\HeritageResourceRequest;

/**
 * Class ResourceTableController.
 */
class ResourceClassificationTypeTableController extends Controller
{
    /**
     * @var ResourceRepository
     */
    protected $resourceClassificationType;

    /**
     * @param ResourceClassificationTypeRepository $resourceClassificationType
     */
    public function __construct(ResourceClassificationTypeRepository $resourceClassificationType)
    {
        $this->resourceClassificationType = $resourceClassificationType;
    }

    /**
     * @param HeritageResourceRequest $request
     *
     * @return mixed
     */
    public function __invoke(HeritageResourceRequest $request)
    {
        $resourceClassificationTypes = $this->resourceClassificationType
            ->getForDataTable($request->get('status'), $request->get('trashed'));

        return Datatables::of($resourceClassificationTypes)
            ->escapeColumns(['type_set', 'type'])
            ->make(true);
    }
}
