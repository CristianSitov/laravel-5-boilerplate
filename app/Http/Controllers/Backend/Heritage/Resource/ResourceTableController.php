<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Http\Transformers\HeritageResourceTransformer;
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
//        $heritageResources = new Fractal\Resource\Collection(
        $heritageResources = $this->resources->getForDataTable($request->get('status'), $request->get('trashed'));
//            new HeritageResourceTransformer
//        );
        dd($heritageResources);

        return Datatables::of($heritageResources)
            ->escapeColumns(['uuid', 'description'])
            ->addColumn('actions', function ($resource) {
                return $resource->action_buttons;
            })
            ->make(true);
    }
}
