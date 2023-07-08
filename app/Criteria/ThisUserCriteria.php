<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisUserCriteria implements CriteriaInterface
{
    /**
     * ThisUserCriteria constructor.
     *
     * @param int $userId
     */
    public function __construct(private int $userId)
    {
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {
        return $model->where('user_id', '=', $this->userId);
    }
}
