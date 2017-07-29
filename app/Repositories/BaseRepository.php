<?php

namespace App\Repositories;

/**
 * Class BaseRepository.
 */
class BaseRepository
{
    protected $entityManager;
    public $model;

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

    public function findPublished()
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison('published', Comparison::EQ, "true"));
        return $this->{static::MODEL}->matching($criteria);
    }
}
