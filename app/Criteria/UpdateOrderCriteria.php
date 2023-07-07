<?php

namespace App\Criteria;

use App\Enum\OrderEnum;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UpdateOrderCriteria implements CriteriaInterface
{
    private int $orderId;

    private int $userId;

    public function __construct(int $orderId, int $userId)
    {
        $this->orderId = $orderId;
        $this->userId  = $userId;
    }

    public function apply($model, RepositoryInterface $repository): mixed
    {
        return $model->where('id', '=', $this->orderId)
            ->where('user_id', $this->userId)
            ->where('status', OrderEnum::STATUS_PENDING);
    }
}
