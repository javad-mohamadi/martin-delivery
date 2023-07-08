<?php

namespace App\Criteria\Company;

use App\Enum\OrderEnum;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UpdateOrderCriteria implements CriteriaInterface
{
    /**
     * @param int $orderId
     */
    public function __construct(private int $orderId)
    {
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {
        return $model->where('id', '=', $this->orderId)
            ->where('status', OrderEnum::STATUS_WAITING);
    }
}
