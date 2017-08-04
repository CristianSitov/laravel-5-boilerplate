<?php

namespace App\Http\Controllers\Backend\Heritage\Component;

use App\Http\Controllers\Controller;
use App\Models\Heritage\ArchitecturalElement;
use App\Repositories\Backend\Heritage\ArchitecturalElementRepository;
use App\Repositories\Backend\Heritage\BuildingRepository;
use App\Repositories\Backend\Heritage\ComponentRepository;
use App\Repositories\Backend\Heritage\ProductionRepository;
use App\Repositories\Backend\Heritage\ResourceRepository;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    protected $resourceRepository;
    protected $productionRepository;
    protected $buildingRepository;
    protected $componentRepository;
    protected $architecturalElementRepository;

    /**
     * Building controller constructor.
     *
     * @param BuildingRepository $buildingRepository
     * @param ProductionRepository $productionRepository
     * @param BuildingRepository $buildingRepository
     * @param ComponentRepository $componentRepository
     * @param ArchitecturalElementRepository $architecturalElementRepository
     */
    public function __construct(ResourceRepository $resourceRepository,
                                ProductionRepository $productionRepository,
                                BuildingRepository $buildingRepository,
                                ComponentRepository $componentRepository,
                                ArchitecturalElementRepository $architecturalElementRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->productionRepository = $productionRepository;
        $this->buildingRepository = $buildingRepository;
        $this->componentRepository = $componentRepository;
        $this->architecturalElementRepository = $architecturalElementRepository;
    }

    public function index($resource_id, $building_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $production = $this->productionRepository->model->find($building_id);
        $placeAddress = $resource->getPlace()->getPlaceAddress();
        $streetName = $placeAddress->getStreetName();
        $address = ucfirst($streetName->getCurrentName()).', nr. '.$placeAddress->getNumber();

        return view('backend.heritage.component.index')
            ->withAddress($address)
            ->withResource($resource)
            ->withProduction($production);
    }

    public function create($resource_id, $building_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $production = $this->productionRepository->model->find($building_id);

        $this->componentRepository->create($production->getBuilding());

        return view('backend.heritage.component.index')
            ->withResource($resource)
            ->withProduction($production);
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($resource_id, $building_id, $component_id)
    {
        $resource = $this->resourceRepository->model->find($resource_id);
        $production = $this->productionRepository->model->find($building_id);
        $building = $production->getBuilding();
        $component = $this->componentRepository->model->find($component_id);
        $component_type = $component->getType();

        $architecturalElements = collect($this->architecturalElementRepository->findPublished($component_type));
        $architectural_elements = [];
        foreach ($architecturalElements as $architecturalElement) {
            if ($architecturalElement->getType() == $component_type) {
                $architectural_elements[$architecturalElement->getType()][$architecturalElement->getSet()][$architecturalElement->getUuid()] = $architecturalElement->getValueRo();
            }
        }
        $architectural_element_map = ArchitecturalElement::MAP;

        $existingArchitecturalElements = $component->getArchitecturalElementsByType($component_type);
        $existing_architectural_elements = [];
        $modifiedElements = [];
        foreach ($existingArchitecturalElements as $existingArchitecturalElement) {
            $existing_architectural_elements[$existingArchitecturalElement->getType()][$existingArchitecturalElement->getSet()][] = $existingArchitecturalElement->getUuid();
            $modifiedElements[$existingArchitecturalElement->getUuid()] = $existingArchitecturalElement->getModified();
        }
        $modifiedElements = array_filter($modifiedElements); // get rid of nulls

        return view('backend.heritage.component.edit')
            ->withResource($resource)
            ->withProduction($production)
            ->withBuilding($building)
            ->withComponent($component)
            ->withComponentType($component_type)
            ->withArchitecturalElements($architectural_elements)
            ->withArchitecturalElementMap($architectural_element_map)
            ->withExistingArchitecturalElements($existing_architectural_elements)
            ->withModifiedElements($modifiedElements);
    }

    public function update(Request $request, $resource_id, $building_id, $component_id)
    {
        $data = $request->all();

        $component = $this->componentRepository->model->find($component_id);

        $this->architecturalElementRepository->updateElement($component, $data);

        return redirect()
            ->route('admin.heritage.components.index', [$resource_id, $building_id])
            ->withFlashSuccess(trans('alerts.backend.com'));
    }

    public function destroy($id)
    {
    }

    public function destroyElement($resource_id, $building_id, $component_id, $uuid)
    {
        $component = $this->componentRepository->model->find($component_id);

        $this->architecturalElementRepository->removeByUuid($component, $uuid);

        return redirect()
            ->route('admin.heritage.components.index', [$resource_id, $building_id])
            ->withFlashSuccess(trans('alerts.backend.elements.deleted'));
    }
}
