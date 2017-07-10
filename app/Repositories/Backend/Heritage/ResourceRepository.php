<?php

namespace App\Repositories\Backend\Heritage;

use App\Events\Backend\Heritage\ResourceCreated;
use App\Models\Heritage\Description;
use App\Models\Heritage\Resource;
use App\Models\Heritage\ResourceClassificationType;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Webpatser\Uuid\Uuid;

/**
 * Class ResourceRepository.
 */
class ResourceRepository extends BaseRepository
{
    protected $resourceRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->model = $this->entityManager->getRepository(Resource::class);
    }

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
//        $query = $this->entityManager
//            ->createQuery("MATCH (resource:HeritageResource)-[:HasNote]->(description:Description) RETURN *");
//        $heritageResources = $query->execute();
        $resources = $this->model->findAll();

        $results = [];
        foreach ($resources as $k => $resource) {
            $results[$k]['uuid'] = $resource->getUuid();
            $results[$k]['description'] = $resource->getDescription()->getNote();
            $results[$k]['created_at'] = $resource->getCreatedAt();
            $results[$k]['updated_at'] = $resource->getUpdatedAt();
            $results[$k]['actions'] = $resource->getActionButtonsAttribute();
        }

        return $results;
    }

    /**
     * @param array $input
     */
    public function create($input)
    {
        $data = $input['data'];

        $resource = new Resource();
        $resource->setUuid((string) Uuid::generate(4));
        $resource->setCreatedAt(new \DateTime());
        $resource->setUpdatedAt(new \DateTime());

        $description = new Description($resource);
        $description->setUuid((string) Uuid::generate(4));
        $description->setNote($data['description']);
        $description->setCreatedAt(new \DateTime());
        $description->setUpdatedAt(new \DateTime());

        $classificationType = $this->entityManager->find(ResourceClassificationType::class, $data['type']);

        $resource->setDescription($description);
        $resource->setClassificationType($classificationType);

        $this->entityManager->persist($resource);
        $this->entityManager->flush();

        event(new ResourceCreated($resource));
    }
}
