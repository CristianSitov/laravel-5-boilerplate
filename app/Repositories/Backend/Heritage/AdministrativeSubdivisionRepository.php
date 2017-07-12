<?php

namespace App\Repositories\Backend\Heritage;

use App\Models\Heritage\AdministrativeSubdivision;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResourceRepository.
 */
class AdministrativeSubdivisionRepository extends BaseRepository
{
    /**
     * import process script
     * LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E48.AdministrativeSubdivision_01.csv" AS row CREATE (n:AdministrativeSubdivision)
     * SET n = row,
     * n.uuid = row.uuid,
     * n.name = row.name,
     * n.created = row.created,
     * n.updated = row.updated;
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->model = $this->entityManager->getRepository(AdministrativeSubdivision::class);
    }

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
    }

    /**
     * @param Model $input
     */
    public function create($input)
    {
    }
}
