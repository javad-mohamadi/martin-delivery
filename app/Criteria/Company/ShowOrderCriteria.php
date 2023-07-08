<?php

namespace App\Criteria\Company;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ShowOrderCriteria implements CriteriaInterface
{
    /**
     * @param int $orderId
     * @param int $companyId
     */
    public function __construct(private int $orderId, private int $companyId)
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
        return $model->where('id', '=', $this->orderId)->where('company_id', $this->companyId);
    }
}
