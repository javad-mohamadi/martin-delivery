<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ShowOrderCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private int $orderId;

    /**
     * @var $userId
     */
    private $userId;

    /**
     * ThisUserCriteria constructor.
     *
     * @param $orderId
     * @param null $userId
     */
    public function __construct($orderId, $userId = null)
    {
        $this->orderId = $orderId;
        $this->userId  = $userId;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {
        if (!$this->userId) {
            $this->userId = Auth::user()->id;
        }

        return $model->where('id', '=', $this->orderId)->where('user_id', $this->userId);
    }
}
