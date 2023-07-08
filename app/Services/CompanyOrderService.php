<?php

namespace App\Services;

use Exception;
use App\Enum\OrderEnum;
use App\Exceptions\LogicException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\DTOs\Company\GetCompanyOrdersDTO;
use App\DTOs\Company\ShowCompanyOrderDTO;
use App\DTOs\Company\CreateCompanyOrderDTO;
use App\DTOs\Company\UpdateCompanyOrderDTO;
use App\Criteria\Company\ShowOrderCriteria;
use App\Criteria\Company\ThisCompanyCriteria;
use App\Criteria\Company\UpdateOrderCriteria;
use Symfony\Component\HttpFoundation\Response;
use App\Criteria\Company\GetPendingOrdersCriteria;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\Order\OrderRepositoryInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Services\Interfaces\CompanyOrderServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
                ->pushCriteria(new ThisCompanyCriteria($dto->companyIds))
                ->orderBy('created_at', 'desc')
                ->paginate();
        } catch (Exception $e) {
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @throws LogicException
     */
    public function show(ShowCompanyOrderDTO $dto)
    {
        try {
            return $this->orderRepository
                ->with('company')
                ->pushCriteria(new ShowOrderCriteria($dto->orderId, $dto->companyId))
                ->first();
        } catch (Exception) {
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param int $id
     * @return LengthAwarePaginator|Collection|mixed
     */
    public function find(int $id): mixed
    {
        return $this->orderRepository->find($id);
    }

    /**
     * @throws LogicException
     */
    public function create(CreateCompanyOrderDTO $dto)
    {
        try {
            if (!in_array($dto->companyId, $dto->userCompanyIds)) {
                throw new LogicException(Response::HTTP_FORBIDDEN);
            }

            $data               = $dto->data;
            $data['company_id'] = $dto->companyId;
            $data['status']     = OrderEnum::STATUS_WAITING;

            return $this->orderRepository->create($data);
        } catch (Exception $e) {
            throw new LogicException(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param UpdateCompanyOrderDTO $dto
     * @return void
     * @throws LogicException
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function update(UpdateCompanyOrderDTO $dto)
    {
        try {
            DB::beginTransaction();
            if (!in_array($dto->companyId, $dto->userCompanyIds)) {
                throw new LogicException(Response::HTTP_FORBIDDEN);
            }
            $order = $this->orderRepository
                ->pushCriteria(new UpdateOrderCriteria($dto->orderId))
                ->pushCriteria(new ThisCompanyCriteria($dto->userCompanyIds))
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
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @return LengthAwarePaginator|Collection|mixed
     * @throws LogicException
     */
    public function getPendingOrders(): mixed
    {
        try {
            return $this->orderRepository
                ->pushCriteria(new GetPendingOrdersCriteria())
                ->paginate();
        } catch (Exception) {
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @throws ValidatorException
     */
    public function updateOrderStatus($orderId, $status)
    {
        $data['status'] = $status;

        return $this->orderRepository->update($data, $orderId);
    }
}
