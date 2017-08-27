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

        $results = [];
        foreach ($resources as $k => $resource) {
            $results[] = [
                'address' => (($resource->getPlace()->getPlaceAddress()->getStreetName()) ? $resource->getPlace()->getPlaceAddress()->getStreetName()->getCurrentName() : '') . ', ' .
                    $resource->getPlace()->getPlaceAddress()->getNumber(),
                'name' => $resource->getCurrentName()->getName(),
                'created_at' => $resource->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $resource->getUpdatedAt()->format('Y-m-d H:i:s'),
                'actions' => $resource->getActionButtonsAttribute(),
            ];
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
        $resource->setUuid((string)Uuid::generate(4));
        $resource->setDeletedAt(null);
        $resource->setPublishedAt(null);
        $resource->setCreatedAt(new \DateTime());
        $resource->setUpdatedAt(new \DateTime());

        foreach ($data['name'] as $k => $input_name) {
            $name = new Name($input_name, $data['name_date_from'][$k] ?: null, $data['name_date_to'][$k] ?: null);

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
                $data['protection_type_date_from'][$l] ?: null, $data['protection_type_date_to'][$l] ?: null,
                $data['protection_type_legal_set'][$l] ?: null, $data['protection_type_legal'][$l] ?: null);

            if (isset($data['current_type'])) {
                if ($data['current_type'] == $l) {
                    $protectionType->setCurrent(true);
                } else {
                    $protectionType->setCurrent(false);
                }
            } else {
                $protectionType->setCurrent(true);
            }

            $protectionType->setName($data['protection_type_name'][$l]);
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
                $updateName->setDateFrom($data['name_date_from'][$namesArray[$f]] ?: null);
                $updateName->setDateTo($data['name_date_to'][$namesArray[$f]] ?: null);
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
                $name = new Name($newName, $data['new_name_date_from'][$k] ?: null, $data['new_name_date_to'][$k] ?: null);

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
        if (!$street || $street->getId() != $data['street']) {
            if ($street) {
                // delete old one
                $query = $this->em->createQuery('MATCH (s:StreetName)-[r]-(p:PlaceAddress) WHERE id(s)='.$street->getId().' DELETE r');
                $result = $query->getResult();
            }
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
                $updateProtection->setDateFrom($data['protection_type_date_from'][$typesArray[$p]] ?: null);
                $updateProtection->setDateTo($data['protection_type_date_to'][$typesArray[$p]] ?: null);
                $updateProtection->setSet($data['protection_type_legal_set'][$typesArray[$p]]);
                $updateProtection->setLegal($data['protection_type_legal'][$typesArray[$p]]);
                $updateProtection->setName($data['protection_type_name'][$typesArray[$p]]);
                unset($typesArray[$p]);

                if ($protectionType->getId() == $data['current_type']) {
                    $updateProtection->setCurrent(true);
                } else {
                    $updateProtection->setCurrent(false);
                }

                $this->em->persist($updateProtection);
                $this->em->flush();
            }
        }

        if (isset($data['new_protection_type'])) {
            foreach ($data['new_protection_type'] as $k => $newProtectionType) {
                $protectionType = new ProtectionType($data['new_protection_type'][$k],
                    $data['new_protection_type_date_from'][$k] ?: null, $data['new_protection_type_date_to'][$k] ?: null,
                    $data['new_protection_type_legal_set'][$k] ?: null, $data['new_protection_type_legal'][$k] ?: null);

                $protectionType->setName($data['new_protection_type_name'][$k]);
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
