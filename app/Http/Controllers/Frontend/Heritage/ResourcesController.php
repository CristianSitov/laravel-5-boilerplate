<?php

namespace App\Http\Controllers\Frontend\Heritage;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Heritage\HeritageRepository;

/**
 * Class FrontendController.
 */
class ResourcesController extends Controller
{
    protected $heritageRepository;

    /**
     * HeritageResource constructor.
     *
     * @param ResourceRepository $resourceRepository
     */
    public function __construct(HeritageRepository $heritageRepository) {
        $this->heritageRepository = $heritageRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $repository = $this->heritageRepository->getForPublic();

        return response()->json($repository);
    }
}
