<?php

namespace App\Repositories\Backend\Heritage;

use App\Http\Transformers\HeritageResourceTransformer;
use App\Models\Heritage\Description;
use App\Models\Heritage\HeritageResource;
use App\Models\Heritage\HeritageResourceClassificationType;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Events\Backend\Heritage\ResourceCreated;
use Webpatser\Uuid\Uuid;

/**
 * Class ResourceRepository.
 */
class ResourceRepository extends BaseRepository
{
    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        $query = $this->entityManager->createQuery("MATCH (r:HeritageResource)-[:HasNote]->(d:Description)
                RETURN *
                LIMIT 10")
            ->addEntityMapping('r', HeritageResource::class)
//            ->addEntityMapping('t', ResourceTypeClassification::class)
//            ->addEntityMapping('p', Place::class)
            ->addEntityMapping('d', Description::class)
//            ->addEntityMapping('n', Name::class)
        ;
        $heritageResources = $query->execute();

//        $repository = $this->entityManager->getRepository(HeritageResource::class);
//        $heritageResources = $repository->findAll();

//        if ($trashed == 'true') {
//            return $results->onlyTrashed();
//        }

        return $heritageResources;
    }

    /**
     * @param Model $input
     */
    public function create($input)
    {
        $data = $input['data'];

        $description = new Description();
        $description->setUuid((string) Uuid::generate(4));
        $description->setDescription($data['description']);

        $resource = new HeritageResource($description);
        $resource->setUuid((string) Uuid::generate(4));

        $this->entityManager->persist($resource);
        $this->entityManager->flush();
    }
}
