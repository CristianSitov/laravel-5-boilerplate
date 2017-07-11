<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Heritage\HeritageResourceRequest;
use App\Models\Heritage\Resource;
use App\Repositories\Backend\Heritage\ResourceTypeClassificationRepository;
use App\Repositories\Backend\Heritage\ResourceRepository;
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
     * HeritageResource constructor.
     *
     * @param ResourceRepository $resourceRepository
     * @param ResourceRepository $resourceRepository
     */
    public function __construct(ResourceRepository $resourceRepository,
                                ResourceTypeClassificationRepository $resourceTypeClassificationRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->resourceTypeClassificationRepository = $resourceTypeClassificationRepository;
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

        return view('backend.heritage.resource.create')
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
                return [$item->getId() => [
                    'id' => $item->getId(),
                    'type_set' => $item->getTypeSet(),
                    'type' => $item->getType(),
                ]];
            });

        return view('backend.heritage.resource.edit')
            ->withResourceTypeClassifications($resourceTypeClassifications)
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
        //
    }
}
