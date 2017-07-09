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
        $query = $this->entityManager
            ->createQuery("MATCH (resource:HeritageResource)-[:HasNote]->(description:Description) RETURN *")
//            ->addEntityMapping('resource', HeritageResource::class)
//            ->addEntityMapping('description', Description::class, \GraphAware\Neo4j\OGM\Query::HYDRATE_RAW)
        ;
        $heritageResources = $query->execute();

        $results = [];
        foreach ($heritageResources as $k => $resource) {
            foreach ($resource as $i => $component) {
                foreach($component->values() as $j => $value) {
                    $results[$k][$i."_".$j] = $value;
                }
            }
        }

        return $results;
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
