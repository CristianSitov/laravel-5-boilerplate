<?php

namespace App\Repositories;

use GraphAware\Neo4j\OGM\EntityManager;

/**
 * Class BaseRepository.
 */
class BaseRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->query()->get();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->query()->count();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->query()->find($id);
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return call_user_func(static::MODEL.'::query');
    }
}
