<?php

namespace App\Criteria\Company;

use App\Enum\OrderEnum;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPendingOrdersCriteria implements CriteriaInterface
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {
        return $model->where('status', '=', OrderEnum::STATUS_WAITING);
    }
}
