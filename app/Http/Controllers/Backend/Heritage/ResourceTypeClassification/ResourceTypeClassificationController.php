<?php

namespace App\Http\Controllers\Backend\Heritage\ResourceTypeClassification;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Heritage\ResourceTypeClassificationRepository;
use App\Repositories\Backend\Heritage\ResourceRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ResourceTypeClassificationController extends Controller
{
    /**
     * @var ResourceRepository
     */
    protected $resourceTypeClassification;

    /**
     * Heritage Resource Type Classification constructor.
     *
     * @param ResourceTypeClassificationRepository $resourceTypeClassificationRepository
     */
    public function __construct(ResourceTypeClassificationRepository $resourceTypeClassificationRepository)
    {
        $this->resourceTypeClassification = $resourceTypeClassificationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('backend.heritage.resource_type_classification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $types = $this->resourceTypeClassification
            ->all();
//            ->mapWithKeys(function ($item) {
//                return [$item->uuid => $item->type];
//            });

        return view('backend.heritage.resource_type_classification.create')
            ->withResourceTypeClassifications($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->resourceTypeClassification->create(['data' => $request->all()]);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
