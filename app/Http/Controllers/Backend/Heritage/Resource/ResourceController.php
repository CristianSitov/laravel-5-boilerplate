<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Heritage\HeritageResourceRequest;
use App\Models\Heritage\ProtectionType;
use App\Models\Heritage\Resource;
use App\Repositories\Backend\Heritage\ActorRepository;
use App\Repositories\Backend\Heritage\AdministrativeSubdivisionRepository;
use App\Repositories\Backend\Heritage\ArchitecturalStyleRepository;
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
     * @var ActorRepository
     */
    protected $actorRepository;

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
                                ActorRepository $actorRepository
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->resourceTypeClassificationRepository = $resourceTypeClassificationRepository;
        $this->administrativeSubdivisionRepository = $administrativeSubdivisionRepository;
        $this->streetNameRepository = $streetNameRepository;
        $this->actorRepository = $actorRepository;
    }

    public function index()
    {
        return view('backend.heritage.resource.index');
    }

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

        $protectionSets = ProtectionType::getSetOptions();
        $protectionTypes = ProtectionType::getTypeOptions();
        $propertyTypes = Resource::getPropertyTypeOptions();

        return view('backend.heritage.resource.create')
            ->withAdministrativeSubdivision($administrativeSubdivision)
            ->withStreetNames($streetNames)
            ->withProtectionSets($protectionSets)
            ->withProtectionTypes($protectionTypes)
            ->withPropertyTypes($propertyTypes)
            ->withResourceTypeClassifications($resourceTypeClassifications);
    }

    public function store(Request $request)
    {
        $this->resourceRepository->create(['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.resource.index')
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }

    public function edit($resource_id, HeritageResourceRequest $request)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $streetName = $placeAddress->getStreetName();
        $address = '';
        if ($streetName) {
            $address = ucfirst($streetName->getCurrentName()).', nr. '.$placeAddress->getNumber();
        }

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

        $protectionSets = ProtectionType::getSetOptions();
        $protectionTypes = ProtectionType::getTypeOptions();
        $propertyTypes = Resource::getPropertyTypeOptions();

        $resourceNames = $resource->getNames();
        $names = [];
        foreach ($resourceNames as $k => $resourceName) {
            $names[] = $resourceName->getId();
        }

        return view('backend.heritage.resource.edit')
            ->withResourceTypeClassifications($resourceTypeClassifications)
            ->withAddress($address)
            ->withAdministrativeSubdivision($administrativeSubdivision)
            ->withStreetNames($streetNames)
            ->withProtectionSets($protectionSets)
            ->withProtectionTypes($protectionTypes)
            ->withPropertyTypes($propertyTypes)
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

    public function actors($id)
    {
        $resource = $this->resourceRepository->model->find($id);
        $actors = $this->actorRepository->findPublished();

        return view('backend.heritage.actors.index')
            ->withResource($resource)
            ->withActors($actors);
    }
}
