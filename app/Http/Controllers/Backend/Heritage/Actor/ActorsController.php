<?php

namespace App\Http\Controllers\Backend\Heritage\Actor;

use App\Models\Heritage\Actor;
use App\Repositories\Backend\Heritage\ActorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Heritage\ResourceRepository;

class ActorsController extends Controller
{
    protected $resourceRepository;
    protected $actorRepository;

    public function __construct(ResourceRepository $resourceRepository,
                                ActorRepository $actorRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->actorRepository = $actorRepository;
    }

    public function index()
    {
    }

    public function create($resource_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);

        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $streetName = $placeAddress->getStreetName();
        $address = ucfirst($streetName->getCurrentName()).', nr. '.$placeAddress->getNumber();

        return view('backend.heritage.actors.create')
            ->withResource($resource)
            ->withAddress($address);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resource_id = (int) $request->getQueryString();
        $resource = $this->resourceRepository->model->find($resource_id);

        $this->actorRepository->store($request->all(), $resource);

        return redirect()
            ->route('admin.heritage.resource.actors.index', $resource_id)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($resource_id, $actor_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);

        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $streetName = $placeAddress->getStreetName();
        $address = ucfirst($streetName->getCurrentName()).', nr. '.$placeAddress->getNumber();

        $actor = $this->actorRepository->model->find($actor_id);

        return view('backend.heritage.actors.edit')
            ->withResource($resource)
            ->withAddress($address)
            ->withActor($actor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $resource_id, $actor_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $actor = $this->actorRepository->model->find($actor_id);

        $this->actorRepository->update($request->all(), $resource, $actor);

        return redirect()
            ->route('admin.heritage.resource.actors.index', $resource_id)
            ->withFlashSuccess(trans('alerts.backend.resources.edited'));
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
