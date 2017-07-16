<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Heritage\HeritageResourceRequest;
use App\Models\Heritage\Resource;
use App\Models\Heritage\StreetName;
use App\Repositories\Backend\Heritage\AdministrativeSubdivisionRepository;
use App\Repositories\Backend\Heritage\HeritageResourceTypeRepository;
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
     * @var HeritageResourceTypeRepository
     */
    protected $heritageResourceTypeRepository;

    /**
     * @var StreetNameRepository
     */
    protected $streetNameRepository;

    /**
     * HeritageResource constructor.
     *
     * @param ResourceRepository $resourceRepository
     * @param ResourceRepository $resourceRepository
     */
    public function __construct(ResourceRepository $resourceRepository,
                                ResourceTypeClassificationRepository $resourceTypeClassificationRepository,
                                AdministrativeSubdivisionRepository $administrativeSubdivisionRepository,
                                HeritageResourceTypeRepository $heritageResourceTypeRepository,
                                StreetNameRepository $streetNameRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->resourceTypeClassificationRepository = $resourceTypeClassificationRepository;
        $this->administrativeSubdivisionRepository = $administrativeSubdivisionRepository;
        $this->heritageResourceTypeRepository = $heritageResourceTypeRepository;
        $this->streetNameRepository = $streetNameRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('backend.heritage.resource.index');
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

        $heritageResourceTypes = collect($this->heritageResourceTypeRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  [
                    'type_set' => $item->getTypeSet(),
                    'type' => $item->getType(),
                ]];
            });

        $streetNames = collect($this->streetNameRepository->model->findAll())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getCurrentName()];
            });

        return view('backend.heritage.resource.edit')
            ->withResourceTypeClassifications($resourceTypeClassifications)
            ->withAdministrativeSubdivision($administrativeSubdivision)
            ->withHeritageResourceTypes($heritageResourceTypes)
            ->withStreetNames($streetNames)
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = $this->resourceRepository->model->find($id);
        $place = $resource->getPlace();
        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $this->resourceRepository->em->remove($placeAddress, true);
        $this->resourceRepository->em->remove($place, true);
        $this->resourceRepository->em->remove($resource, true);
        $this->resourceRepository->em->flush();

        return redirect()
            ->route('admin.heritage.resource.index')
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }
}
