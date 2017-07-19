<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Heritage\HeritageResourceRequest;
use App\Models\Heritage\ArchitecturalStyle;
use App\Models\Heritage\Resource;
use App\Models\Heritage\StreetName;
use App\Repositories\Backend\Heritage\AdministrativeSubdivisionRepository;
use App\Repositories\Backend\Heritage\ArchitecturalStyleRepository;
use App\Repositories\Backend\Heritage\HeritageResourceTypeRepository;
use App\Repositories\Backend\Heritage\PlotPlanRepository;
use App\Repositories\Backend\Heritage\ResourceTypeClassificationRepository;
use App\Repositories\Backend\Heritage\ResourceRepository;
use App\Repositories\Backend\Heritage\StreetNameRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * @var ResourceRepository
     */
    protected $resourceRepository;

    /**
     * @var ResourceTypeClassificationRepository
     */
    protected $resourceTypeClassificationRepository;

    /**
     * @var AdministrativeSubdivisionRepository
     */
    protected $administrativeSubdivisionRepository;

    /**
     * @var ArchitecturalStyleRepository
     */
    protected $architecturalStyleRepository;

    /**
     * @var HeritageResourceTypeRepository
     */
    protected $heritageResourceTypeRepository;

    /**
     * @var StreetNameRepository
     */
    protected $streetNameRepository;

    /**
     * @var PlotPlanRepository
     */
    protected $plotPlanRepository;

    /**
     * HeritageResource constructor.
     *
     * @param ResourceRepository $resourceRepository
     */
    public function __construct(ResourceRepository $resourceRepository,
                                ResourceTypeClassificationRepository $resourceTypeClassificationRepository,
                                AdministrativeSubdivisionRepository $administrativeSubdivisionRepository,
                                StreetNameRepository $streetNameRepository,
                                ArchitecturalStyleRepository $architecturalStyleRepository,
                                HeritageResourceTypeRepository $heritageResourceTypeRepository,
                                PlotPlanRepository $plotPlanRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->resourceTypeClassificationRepository = $resourceTypeClassificationRepository;
        $this->administrativeSubdivisionRepository = $administrativeSubdivisionRepository;
        $this->streetNameRepository = $streetNameRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('backend.heritage.resource.index')
            ->withStatuses(ResourceRepository::STATUSES)
            ->withProgresses(ResourceRepository::PROGRESSES);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $resourceTypeClassifications = collect($this->resourceTypeClassificationRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getType()];
            });

        $administrativeSubdivision = collect($this->administrativeSubdivisionRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getName()];
            });

        $streetNames = collect($this->streetNameRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getCurrentName()];
            });

        return view('backend.heritage.resource.create')
            ->withAdministrativeSubdivision($administrativeSubdivision)
            ->withStreetNames($streetNames)
            ->withResourceTypeClassifications($resourceTypeClassifications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->resourceRepository->create(['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.resource.index')
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Resource                $resource
     * @param HeritageResourceRequest $request
     *
     * @return mixed
     */
    public function edit($resource_id, HeritageResourceRequest $request)
    {
        $resource = $this->resourceRepository->model->find($resource_id);

        $resourceTypeClassifications = collect($this->resourceTypeClassificationRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getType()];
            });

        $administrativeSubdivision = collect($this->administrativeSubdivisionRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getName()];
            });

        $streetNames = collect($this->streetNameRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getCurrentName()];
            });

        // SCOUT
        $heritageResourceTypes = collect($this->heritageResourceTypeRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => [
                    'id' => $item->getId(),
                    'set_ro' => $item->getSetRo(),
                    'name_ro' => $item->getNameRo(),
                ]];
            });

        $architecturalStyles = collect($this->architecturalStyleRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getNameRo()];
            });

        $plotPlan = collect($this->plotPlanRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getNameRo()];
            });

        return view('backend.heritage.resource.edit')
            ->withResourceTypeClassifications($resourceTypeClassifications)
            ->withAdministrativeSubdivision($administrativeSubdivision)
            ->withStreetNames($streetNames)
            ->withHeritageResourceTypes($heritageResourceTypes)
            ->withArchitecturalStyles($architecturalStyles)
            ->withPlotPlan($plotPlan)
            ->withResource($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->resourceRepository->update($id, ['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.resource.index')
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }

    /**
     * Undelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->resourceRepository->restoreDelete($id);

        return redirect()
            ->route('admin.heritage.resource.index')
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->resourceRepository->softDelete($id);

        return redirect()
            ->route('admin.heritage.resource.index')
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }
}
