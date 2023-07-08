<?php

namespace App\Criteria\Courier;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ShowCourierOrderCriteria implements CriteriaInterface
{
    /**
     * @param int $courierOrderId
     */
    public function __construct(private int $courierOrderId)
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
        return $model->where('id', '=', $this->courierOrderId);
    }
}
