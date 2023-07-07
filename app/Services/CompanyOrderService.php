<?php

namespace App\Services;

use Exception;
use App\Enum\OrderEnum;
use App\Exceptions\LogicException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Criteria\ThisUserCriteria;
use App\Criteria\ShowOrderCriteria;
use App\Criteria\UpdateOrderCriteria;
use App\DTOs\Company\GetCompanyOrdersDTO;
use App\DTOs\Company\ShowCompanyOrdersDTO;
use App\DTOs\Company\CreateCompanyOrdersDTO;
use App\DTOs\Company\UpdateCompanyOrdersDTO;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\Interfaces\CompanyOrderServiceInterface;

class CompanyOrderService implements CompanyOrderServiceInterface
{
    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(protected OrderRepositoryInterface $orderRepository)
    {
    }

    /**
     * @throws LogicException
     */
    public function index(GetCompanyOrdersDTO $dto)
    {
        try {
            return $this->orderRepository
                ->pushCriteria(new ThisUserCriteria($dto->companyId))
                ->orderBy('created_at', 'desc')
                ->paginate();
        } catch (Exception) {
            throw new LogicException();
        }
    }

    /**
     * @throws LogicException
     */
    public function show(ShowCompanyOrdersDTO $dto)
    {
        try {
            return $this->orderRepository
                ->pushCriteria(new ShowOrderCriteria($dto->orderId, $dto->companyId))
                ->first();
        } catch (Exception) {
            throw new LogicException();
        }
    }

    /**
     * @throws LogicException
     */
    public function create(CreateCompanyOrdersDTO $dto)
    {
        try {
            $data            = $dto->data;
            $data['user_id'] = $dto->companyId;
            $data['status']  = OrderEnum::STATUS_PENDING;

            return $this->orderRepository->create($data);
        } catch (Exception $e) {
            throw new LogicException();
        }
    }

    /**
     * @param UpdateCompanyOrdersDTO $dto
     * @return void
     * @throws LogicException
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function update(UpdateCompanyOrdersDTO $dto)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderRepository
                ->pushCriteria(new UpdateOrderCriteria($dto->orderId, $dto->companyId))
                ->first();

            if (!$order) {
                throw new LogicException(Response::HTTP_NOT_FOUND);
            }

            $order->lockForUpdate();
            $data = [
                'status' => $dto->status,
            ];
            $this->orderRepository->update($data, $dto->orderId);

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            if ($exception->getCode() === '40001' || $exception->getCode() === 'HY000') {
                throw new LogicException($exception->getCode(),'Concurrency issue occurred. Please retry.');
            }
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }
}
