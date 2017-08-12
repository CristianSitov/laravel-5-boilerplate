<?php

namespace App\Repositories\Backend\Heritage;

use App\Events\Backend\Heritage\ResourceCreated;
use App\Events\Backend\Heritage\ResourceUpdated;
use App\Models\Heritage\AdministrativeSubdivision;
use App\Models\Heritage\Description;
use App\Models\Heritage\Name;
use App\Models\Heritage\Place;
use App\Models\Heritage\PlaceAddress;
use App\Models\Heritage\ProtectionType;
use App\Models\Heritage\Resource;
use App\Models\Heritage\ResourceTypeClassification;
use App\Models\Heritage\StreetName;
use App\Repositories\BaseRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use Webpatser\Uuid\Uuid;

/**
 * Class ResourceRepository.
 */
class ResourceRepository extends BaseRepository
{
    const STATUSES = [
        'field_ready' => [
            'label' => 'default',
            'name' => 'I. Desk - Imported'
        ],
        'field_done' => [
            'label' => 'danger',
            'name' => 'II. Field - Mapped',
        ],
        'moderated' => [
            'label' => 'warning',
            'name' => 'III. Desk - Evaluated',
        ],
        'published' => [
            'label' => 'info',
            'name' => 'IV. Published',
        ],
    ];

    const PROGRESSES = [
        '15' => [
            'label' => 'default',
            'value' => '15'
        ],
        '30' => [
            'label' => 'danger',
            'value' => '30',
        ],
        '60' => [
            'label' => 'warning',
            'value' => '60',
        ],
        '80' => [
            'label' => 'info',
            'value' => '80',
        ],
        '100' => [
            'label' => 'success',
            'value' => '100',
        ],
    ];

    /**
     * @var EntityManager
     */
    public $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->model = $this->em->getRepository(Resource::class);
    }

    public function getForDataTable($without_trashed = true, $published_only = true)
    {
        if (!$without_trashed) {
            // admin
            $resources = $this->model->findAll();
        } else {
            if ($published_only) {
                // public
                $queryResults = $this->em->createQuery('MATCH (r:Resource) WHERE r.published IS NOT NULL AND r.deleted_at IS NULL RETURN r');
            } else {
                // desk/scout
                $queryResults = $this->em->createQuery('MATCH (r:Resource) WHERE r.deleted_at IS NULL RETURN r');
            }
            $queryResults->addEntityMapping('r', Resource::class);
            $resources = $queryResults->getResult();
        }

        return $resources;
    }

    /**
     * @param array $input
     */
    public function create($input)
    {
        $data = $input['data'];

        $resource = new Resource();
        $resource->setUuid((string)Uuid::generate(4));
        $resource->setProgress(15);
        $resource->setDeletedAt(null);
        $resource->setPublishedAt(null);
        $resource->setCreatedAt(new \DateTime());
        $resource->setUpdatedAt(new \DateTime());

        foreach ($data['name'] as $k => $input_name) {
            $name = new Name($input_name,
                \DateTime::createFromFormat('Y', $data['name_date_from'][$k]) ?: null,
                \DateTime::createFromFormat('Y', $data['name_date_to'][$k]) ?: null);

            if (isset($data['current_name'])) {
                if ($data['current_name'] == $k) {
                    $name->setCurrent(true);
                } else {
                    $name->setCurrent(false);
                }
            } else {
                $name->setCurrent(true);
            }

            $name->setUuid((string)Uuid::generate(4));
            $name->setCreatedAt(new \DateTime());
            $name->setUpdatedAt(new \DateTime());
            $resource->getNames()->add($name);
        }

        $description = new Description($resource);
        $description->setUuid((string)Uuid::generate(4));
        $description->setNote($data['description']);
        $description->setCreatedAt(new \DateTime());
        $description->setUpdatedAt(new \DateTime());

        $resourceTypeClassification = $this->em->find(ResourceTypeClassification::class, $data['type']);

        $resource->setDescription($description);
        $resource->setResourceTypeClassification($resourceTypeClassification);

        // initialize nodes
        // LOCATION
        $district = $this->em->find(AdministrativeSubdivision::class, $data['district']);
        $streetName = $this->em->find(StreetName::class, $data['street']);
        $place = new Place();
        $placeAddress = new PlaceAddress();
        $placeAddress->setStreetName($streetName);
        $placeAddress->setNumber($data['number']);
        $place->setPlaceAddress($placeAddress);
        $resource->setPlace($place);

        // LEGALS (judicial, proprietary)
        foreach ($data['protection_type'] as $l => $input_property_type) {
            $protectionType = new ProtectionType($data['protection_type'][$l],
                \DateTime::createFromFormat('Y', $data['protection_type_date_from'][$l]) ?: null,
                \DateTime::createFromFormat('Y', $data['protection_type_date_to'][$l]) ?: null,
                $data['protection_type_legal_set'][$l] ?: null,
                $data['protection_type_legal'][$l] ?: null);

            if (isset($data['current_type'])) {
                if ($data['current_type'] == $l) {
                    $protectionType->setCurrent(true);
                } else {
                    $protectionType->setCurrent(false);
                }
            } else {
                $protectionType->setCurrent(true);
            }

            $protectionType->setUuid((string)Uuid::generate(4));
            $protectionType->setCreatedAt(new \DateTime());
            $protectionType->setUpdatedAt(new \DateTime());
            $resource->getProtectionTypes()->add($protectionType);
        }

        $this->em->persist($resource);
        $this->em->flush();

        event(new ResourceCreated($resource));
    }

    /**
     * @param int $id
     * @param array $input
     */
    public function update($id, $input)
    {
        $data = $input['data'];

        $resource = $this->em->find(Resource::class, $id);

        $namesArray = array_keys($data['name']);
        foreach ($resource->getNames() as $name) {
            $f = array_search($name->getId(), $namesArray);
            if ($f !== false) {
                // update this if matches ID
                $updateName = $this->em->find(Name::class, $name->getId());
                $updateName->setName($data['name'][$namesArray[$f]]);
                $updateName->setDateFrom(\DateTime::createFromFormat('Y', $data['name_date_from'][$namesArray[$f]]) ?: null);
                $updateName->setDateTo(\DateTime::createFromFormat('Y', $data['name_date_to'][$namesArray[$f]]) ?: null);
                unset($namesArray[$f]);
                $this->em->persist($updateName);
                $this->em->flush();
            } else {
                // delete
                // @TODO: see how can this be deleted
            }
        }

        if (isset($data['new_name'])) {
            foreach ($data['new_name'] as $k => $newName) {
                $name = new Name($newName,
                    \DateTime::createFromFormat('Y', $data['new_name_date_from'][$k]) ?: null,
                    \DateTime::createFromFormat('Y', $data['new_name_date_to'][$k]) ?: null);

                if (isset($data['current_name'])) {
                    if ($data['current_name'] == ($k + count($data['name']))) {
                        $name->setCurrent(true);
                    } else {
                        $name->setCurrent(false);
                    }
                } else {
                    $name->setCurrent(true);
                }

                $name->setUuid((string)Uuid::generate(4));
                $name->setCreatedAt(new \DateTime());
                $name->setUpdatedAt(new \DateTime());
                $resource->getNames()->add($name);
            }
        }

        $resource->getDescription()->setNote($data['description']);

        $street = $resource->getPlace()->getPlaceAddress()->getStreetName();
        if ($street->getId() != $data['street']) {
            // delete old one
            $query = $this->em->createQuery('MATCH (s:StreetName)-[r]-(p:PlaceAddress) WHERE id(s)='.$street->getId().' DELETE r');
            $result = $query->getResult();
            // find & add new one
            $newStreet = $this->em->find(StreetName::class, $data['street']);
            $resource->getPlace()->getPlaceAddress()->setStreetName($newStreet);
        }

        $number = $resource->getPlace()->getPlaceAddress();
        if ($data['number'] != $number->getNumber()) {
            $number->setNumber($data['number']);
        }

        $typesArray = array_keys($data['protection_type']);
        foreach ($resource->getProtectionTypes() as $protectionType) {
            $p = array_search($protectionType->getId(), $typesArray);
            if ($p !== false) {
                $updateProtection = $this->em->find(ProtectionType::class, $protectionType->getId());
                $updateProtection->setType($data['protection_type'][$typesArray[$p]]);
                $updateProtection->setDateFrom(\DateTime::createFromFormat('Y', $data['protection_type_date_from'][$typesArray[$p]]) ?: null);
                $updateProtection->setDateTo(\DateTime::createFromFormat('Y', $data['protection_type_date_to'][$typesArray[$p]]) ?: null);
                $updateProtection->setSet($data['protection_type_legal_set'][$typesArray[$p]]);
                $updateProtection->setLegal($data['protection_type_legal'][$typesArray[$p]]);
                unset($typesArray[$p]);
                $this->em->persist($updateProtection);
                $this->em->flush();
            }
        }

        if (isset($data['new_protection_type'])) {
            foreach ($data['new_protection_type'] as $k => $newProtectionType) {
                $protectionType = new ProtectionType($data['new_protection_type'][$k],
                    \DateTime::createFromFormat('Y', $data['new_protection_type_date_from'][$k]) ?: null,
                    \DateTime::createFromFormat('Y', $data['new_protection_type_date_to'][$k]) ?: null,
                    $data['new_protection_type_legal_set'][$k] ?: null,
                    $data['new_protection_type_legal'][$k] ?: null);

                if (isset($data['current_type'])) {
                    if ($data['current_type'] == ($k + count($data['protection_type']))) {
                        $protectionType->setCurrent(true);
                    } else {
                        $protectionType->setCurrent(false);
                    }
                } else {
                    $protectionType->setCurrent(true);
                }

                $protectionType->setUuid((string)Uuid::generate(4));
                $protectionType->setCreatedAt(new \DateTime());
                $protectionType->setUpdatedAt(new \DateTime());
                $resource->getProtectionTypes()->add($protectionType);
            }
        }

        $resource->setPropertyType($data['property_type']);

        $this->em->persist($resource);
        $this->em->flush();

        event(new ResourceUpdated($resource));
    }

    /**
     * @param int $id
     */
    public function softDelete($id)
    {
        $resource = $this->em->find(Resource::class, $id);
        $resource->setDeletedAt(new \DateTime());
        $this->em->persist($resource);
        $this->em->flush();
    }

    /**
     * @param int $id
     */
    public function restoreDelete($id)
    {
        $resource = $this->em->find(Resource::class, $id);
        $resource->setDeletedAt(null);
        $this->em->persist($resource);
        $this->em->flush();
    }
}
