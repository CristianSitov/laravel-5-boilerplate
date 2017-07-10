<?php

namespace App\Http\Controllers\Backend\Heritage\ClassificationType;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Heritage\ResourceClassificationTypeRepository;
use App\Repositories\Backend\Heritage\ResourceRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ResourceClassificationTypeController extends Controller
{
    /**
     * @var ResourceRepository
     */
    protected $resourceClassificationType;

    /**
     * Heritage Resource Classification Type constructor.
     *
     * @param ResourceClassificationTypeRepository $resourceClassificationTypeRepository
     */
    public function __construct(ResourceClassificationTypeRepository $resourceClassificationTypeRepository)
    {
        $this->resourceClassificationType = $resourceClassificationTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('backend.heritage.classification_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $types = $this->resourceClassificationType
            ->all();
//            ->mapWithKeys(function ($item) {
//                return [$item->uuid => $item->type];
//            });

        return view('backend.heritage.classification_type.create')
            ->withResourceClassificationType($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->resourceClassificationType->create(['data' => $request->all()]);

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
