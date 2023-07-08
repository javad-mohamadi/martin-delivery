<?php

namespace App\Criteria\Company;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisCompanyCriteria implements CriteriaInterface
{
    /**
     * ThisUserCriteria constructor.
     *
     * @param array $userCompanyIds
     */
    public function __construct(private array $userCompanyIds)
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
        return $model->whereIn('company_id', $this->userCompanyIds);
    }
}
