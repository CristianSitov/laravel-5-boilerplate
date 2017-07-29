<?php


namespace App\Http\Controllers\Backend\Heritage\Building;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Heritage\MaterialRepository;
use App\Repositories\Backend\Heritage\ModificationTypeRepository;
use Illuminate\Http\Request;
use App\Models\Heritage\Resource;
use App\Repositories\Backend\Heritage\ArchitecturalStyleRepository;
use App\Repositories\Backend\Heritage\BuildingRepository;
use App\Repositories\Backend\Heritage\HeritageResourceTypeRepository;
use App\Repositories\Backend\Heritage\PlotPlanRepository;
use App\Repositories\Backend\Heritage\ProductionRepository;
use App\Repositories\Backend\Heritage\ResourceRepository;
use GraphAware\Neo4j\OGM\EntityManager;

class BuildingController extends Controller
{
    protected $resourceRepository;
    protected $productionRepository;
    protected $buildingRepository;
    protected $heritageResourceTypeRepository;
    protected $architecturalStyleRepository;
    protected $plotPlanRepository;
    protected $materialRepository;
    protected $modificationTypeRepository;

    /**
     * Building controller constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(ResourceRepository $resourceRepository,
        ProductionRepository $productionRepository,
        BuildingRepository $buildingRepository,
        ArchitecturalStyleRepository $architecturalStyleRepository,
        HeritageResourceTypeRepository $heritageResourceTypeRepository,
        PlotPlanRepository $plotPlanRepository,
        MaterialRepository $materialRepository,
        ModificationTypeRepository $modificationTypeRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->productionRepository = $productionRepository;
        $this->buildingRepository = $buildingRepository;
        $this->architecturalStyleRepository = $architecturalStyleRepository;
        $this->heritageResourceTypeRepository = $heritageResourceTypeRepository;
        $this->plotPlanRepository = $plotPlanRepository;
        $this->materialRepository = $materialRepository;
        $this->modificationTypeRepository = $modificationTypeRepository;
    }

    public function index($resource_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);

        return view('backend.heritage.building.index')
            ->withResource($resource);
    }

    public function create($resource_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);

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

        $materials = collect($this->materialRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getNameRo()];
            });

        $modification_types = collect($this->modificationTypeRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getNameRo()];
            });

        return view('backend.heritage.building.create')
            ->withHeritageResourceTypes($heritageResourceTypes)
            ->withArchitecturalStyles($architecturalStyles)
            ->withPlotPlan($plotPlan)
            ->withMaterials($materials)
            ->withModificationTypes($modification_types)
            ->withResource($resource);
    }

    public function store($resource_id, Request $request)
    {
        $this->resourceRepository->createBuilding($resource_id, ['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.buildings.index', $resource_id)
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }

    public function edit($resource_id, $production_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $production = $this->productionRepository->model->find($production_id);
        $current_types = $production->getBuilding()->getHeritageResourceTypeIds();
        $current_styles = $production->getBuilding()->getArchitecturalStyleIds();
        $current_materials = $production->getBuilding()->getBuildingConsistsOfMaterialIds();

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

        $materials = collect($this->materialRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getNameRo()];
            });

        $modification_types = collect($this->modificationTypeRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getNameRo()];
            });

        $data = [
            'date_from' => $production->getProductionEvent() ? $production->getProductionEvent()->getFromDate() : '',
            'date_to'   => $production->getProductionEvent() ? $production->getProductionEvent()->getToDate() : '',
        ];

        return view('backend.heritage.building.edit')
            ->withHeritageResourceTypes($heritageResourceTypes)
            ->withCurrentTypes($current_types)
            ->withArchitecturalStyles($architecturalStyles)
            ->withCurrentStyles($current_styles)
            ->withPlotPlan($plotPlan)
            ->withMaterials($materials)
            ->withModificationTypes($modification_types)
            ->withCurrentMaterials($current_materials)
            ->withData($data)
            ->withProduction($production)
            ->withResource($resource);
    }

    public function update($resource_id, $building_id, Request $request)
    {
        $this->resourceRepository->updateBuilding($building_id, ['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.buildings.index', $resource_id)
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }
}
