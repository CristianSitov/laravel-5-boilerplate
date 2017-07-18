<?php


namespace App\Http\Controllers\Backend\Heritage\Building;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Heritage\Resource;
use App\Repositories\Backend\Heritage\ArchitecturalStyleRepository;
use App\Repositories\Backend\Heritage\HeritageResourceTypeRepository;
use App\Repositories\Backend\Heritage\PlotPlanRepository;
use App\Repositories\Backend\Heritage\ResourceRepository;
use GraphAware\Neo4j\OGM\EntityManager;

class BuildingController extends Controller
{
    protected $resourceRepository;
    protected $heritageResourceTypeRepository;
    protected $architecturalStyleRepository;
    protected $plotPlanRepository;

    /**
     * Building controller constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(ResourceRepository $resourceRepository,
        ArchitecturalStyleRepository $architecturalStyleRepository,
        HeritageResourceTypeRepository $heritageResourceTypeRepository,
        PlotPlanRepository $plotPlanRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->architecturalStyleRepository = $architecturalStyleRepository;
        $this->heritageResourceTypeRepository = $heritageResourceTypeRepository;
        $this->plotPlanRepository = $plotPlanRepository;
    }

    public function index($resource)
    {
        $resource = $this->resourceRepository->model->find($resource);

        return view('backend.heritage.building.index')
            ->withResource($resource);
    }

    public function edit($resource_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);

        $heritageResourceTypes = collect($this->heritageResourceTypeRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  [
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

        return view('backend.heritage.building.edit')
            ->withHeritageResourceTypes($heritageResourceTypes)
            ->withArchitecturalStyles($architecturalStyles)
            ->withPlotPlan($plotPlan)
            ->withResource($resource);
    }

    public function update($id, Request $request)
    {
        $this->resourceRepository->updateBuilding($id, ['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.building.get')
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }
}
