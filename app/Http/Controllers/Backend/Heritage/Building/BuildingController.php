<?php


namespace App\Http\Controllers\Backend\Heritage\Building;

use App\Http\Controllers\Controller;
use App\Models\Heritage\Building;
use App\Repositories\Backend\Heritage\MaterialRepository;
use App\Repositories\Backend\Heritage\ModificationTypeRepository;
use Illuminate\Http\Request;
use App\Models\Heritage\Resource;
use App\Repositories\Backend\Heritage\ArchitecturalStyleRepository;
use App\Repositories\Backend\Heritage\BuildingRepository;
use App\Repositories\Backend\Heritage\HeritageResourceTypeRepository;
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
    protected $materialRepository;
    protected $modificationTypeRepository;

    /**
     * Building controller constructor.
     *
     * @param ResourceRepository $resourceRepository
     * @param ProductionRepository $productionRepository
     * @param BuildingRepository $buildingRepository
     * @param ArchitecturalStyleRepository $architecturalStyleRepository
     * @param HeritageResourceTypeRepository $heritageResourceTypeRepository
     * @param MaterialRepository $materialRepository
     * @param ModificationTypeRepository $modificationTypeRepository
     */
    public function __construct(ResourceRepository $resourceRepository,
        ProductionRepository $productionRepository,
        BuildingRepository $buildingRepository,
        ArchitecturalStyleRepository $architecturalStyleRepository,
        HeritageResourceTypeRepository $heritageResourceTypeRepository,
        MaterialRepository $materialRepository,
        ModificationTypeRepository $modificationTypeRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->productionRepository = $productionRepository;
        $this->buildingRepository = $buildingRepository;
        $this->architecturalStyleRepository = $architecturalStyleRepository;
        $this->heritageResourceTypeRepository = $heritageResourceTypeRepository;
        $this->materialRepository = $materialRepository;
        $this->modificationTypeRepository = $modificationTypeRepository;
    }

    public function index($resource_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $streetName = $placeAddress->getStreetName();
        $address = ucfirst($streetName->getCurrentName()).', nr. '.$placeAddress->getNumber();

        return view('backend.heritage.building.index')
            ->withAddress($address)
            ->withResource($resource);
    }

    public function create($resource_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $streetName = $placeAddress->getStreetName();
        $address = ucfirst($streetName->getCurrentName()).', nr. '.$placeAddress->getNumber();

        $levels = Building::LEVELS;

        $heritageResourceTypes = collect($this->heritageResourceTypeRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => [
                    'id' => $item->getId(),
                    'set_order' => $item->getSetOrder(),
                    'set_ro' => $item->getSetRo(),
                    'name_order' => $item->getNameOrder(),
                    'name_ro' => $item->getNameRo(),
                ]];
            })
            ->sort(function ($a, $b) {
                // sort by column1 first, then 2, and so on
                return strcmp($a['set_order'], $b['set_order'])
                    ?: strcmp($a['name_order'], $b['name_order']);
            });

        $architecturalStyles = collect($this->architecturalStyleRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getNameRo()];
            });

        $materials = collect($this->materialRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getNameRo()];
            });

        $modification_types = collect($this->modificationTypeRepository->findPublished('building'))
            ->mapWithKeys(function ($item) {
                return [$item->getId() => $item->getNameRo()];
            });

        return view('backend.heritage.building.create')
            ->withAddress($address)
            ->withLevels($levels)
            ->withHeritageResourceTypes($heritageResourceTypes)
            ->withArchitecturalStyles($architecturalStyles)
            ->withMaterials($materials)
            ->withModificationTypes($modification_types)
            ->withResource($resource);
    }

    public function store($resource_id, Request $request)
    {
        $this->buildingRepository->storeBuilding($resource_id, ['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.buildings.index', $resource_id)
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }

    public function edit($resource_id, $production_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $streetName = $placeAddress->getStreetName();
        $address = ucfirst($streetName->getCurrentName()).', nr. '.$placeAddress->getNumber();
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

        $materials = collect($this->materialRepository->findPublished())
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getNameRo()];
            });

        $modification_types = collect($this->modificationTypeRepository->findPublished('building'))
            ->mapWithKeys(function ($item) {
                return [$item->getId() =>  $item->getNameRo()];
            });

        $data = [
            'date_from' => $production->getProductionEvent() ?
                \DateTime::createFromFormat('Y/m/d', $production->getProductionEvent()->getFromDate()) : '',
            'date_to'   => $production->getProductionEvent() ?
                \DateTime::createFromFormat('Y/m/d', $production->getProductionEvent()->getToDate()) : '',
        ];

        return view('backend.heritage.building.edit')
            ->withHeritageResourceTypes($heritageResourceTypes)
            ->withAddress($address)
            ->withCurrentTypes($current_types)
            ->withArchitecturalStyles($architecturalStyles)
            ->withCurrentStyles($current_styles)
            ->withMaterials($materials)
            ->withModificationTypes($modification_types)
            ->withCurrentMaterials($current_materials)
            ->withData($data)
            ->withProduction($production)
            ->withResource($resource);
    }

    public function update($resource_id, $production_id, Request $request)
    {
        $this->buildingRepository->updateBuilding($production_id, ['data' => $request->all()]);

        return redirect()
            ->route('admin.heritage.buildings.index', $resource_id)
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }

    public function remove($resource_id, $building_id)
    {
        $this->buildingRepository->removeBuilding($building_id);

        return redirect()
            ->route('admin.heritage.buildings.index', $resource_id)
            ->withFlashSuccess(trans('alerts.backend.resources.created'));
    }
}
