<?php

namespace App\Http\Controllers\Backend\Heritage\Actor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Heritage\ActorsRequest;
use App\Repositories\Backend\Heritage\ActorRepository;
use Yajra\Datatables\Facades\Datatables;

/**
 * Class ResourceTableController.
 */
class ActorsTableController extends Controller
{
    /**
     * @var ActorRepository
     */
    protected $actorsRepository;

    /**
     * @param ActorRepository $actorsRepository
     */
    public function __construct(ActorRepository $actorsRepository)
    {
        $this->actorsRepository = $actorsRepository;
    }

    /**
     * @param ActorsRequest $request
     *
     * @return mixed
     */
    public function __invoke(ActorsRequest $request)
    {
//        if (access()->hasRole('Administrator')) {
//            $heritageResources = $this->actorsRepository->getForDataTable(false, false);
//        } else if (access()->hasRole('Scout') || access()->hasRole('Desk')) {
//            $heritageResources = $this->actorsRepository->getForDataTable(true, false);
//        }
        $resource_id = (int) $request->getQueryString();
        $actors = $this->actorsRepository->getForDataTable($resource_id, false, false);

        return Datatables::of($actors)
            ->escapeColumns(['address', 'name'])
            ->make(true);
    }
}
